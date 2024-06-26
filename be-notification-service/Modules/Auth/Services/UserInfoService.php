<?php

namespace Modules\Auth\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\UserInfo;

class UserInfoService
{

    public function updateInfo(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user();
            $user->update([
                'email' => $request->input('email')
            ]);
            $user_info = $user->info;
            $user_info->update($request->all());
            DB::commit();
            return $user_info;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function changePassword(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            if (Hash::check($request->get('current_password'), $user->password)) {
                $data = [
                    'password' => Hash::make($request->get('password'))
                ];
                $user->update($data);
                DB::commit();
                return true;
            } else {
                throw new Exception(__('auth::message.password.change_current_password_failed'), 500);
            }

            return;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function statisUserTypeByMonth(Request $request)
    {
        if ($request->has('start_date') && $request->has('end_date')) {
            $data = UserInfo::whereBetween('created_at', [$request->start_date, $request->end_date])
                ->select('type', DB::raw("count('id') as total_user"))
                ->groupBy('type')
                ->get();
        } else {
            $data = UserInfo::select('type', DB::raw("count('id') as total_user"))
                ->groupBy('type')
                ->get();
        }
        return $data;
    }
}
