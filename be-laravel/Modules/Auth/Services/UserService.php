<?php

namespace Modules\Auth\Services;

use App\Exceptions\ApiException;
use App\Models\User;
use DateTime;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Quiz\Models\ExamChanel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Notification;
use Modules\Auth\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Notifications\ResetPasswordUserNotification;

class UserService extends BaseService
{

    public function __construct(UserRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    public function getList(Request $request)
    {
        $has_chanel = request()->query('has_chanel');
        $has_vip = $request->query('has_vip');
        $type = request()->query('type');
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository->withCount(['planSubscriptions as has_vip' => function ($query) {
            $query->where('name', 'vip')->findActive();
        }]);
        if ($request->has('has_chanel')) {
            $chanel_user_ids = ExamChanel::where('user_id', '<>', null)->pluck('user_id');
            if ($has_chanel == 'true') {
                $collection = $collection->whereIn('id', $chanel_user_ids)->where('status', 'VERIFIED');
            }
            if ($has_chanel == 'false') {
                $collection = $collection->whereNotIn('id', $chanel_user_ids)->where('status', 'VERIFIED');
            }
        }
        if ($request->has('has_vip')) {
            if ($has_vip == 1) {
                $collection->whereHas('planSubscriptions', function ($query) {
                    $query->where('name', 'vip')->findActive();
                });
            } elseif ($has_vip == 0) {
                $collection->whereDoesntHave('planSubscriptions', function ($query) {
                    $query->where('name', 'vip')->findActive();
                });
            }
        }
        if($type){
            $collection = $collection->whereHas('info', function($query) use($type){
                $query->where('type', $type);
            });
        }

        $collection = $collection->orderBy($this->sort, $this->dir)->paginate($this->limit);
        return $collection;
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->baseRepository->create([
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ]);
            $user->markEmailAsVerified();
            $user->info()->create($request->input('user_info'));
            // event(new Registered($user));
            DB::commit();
            return $user;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = [
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
            ];

            $user = $this->baseRepository->update($data, $id);
            // $user->info()->update($request->input('user_info'));
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function blockUser($id)
    {
        try {
            DB::beginTransaction();
            $user = $this->baseRepository->find($id);
            $user->block();
            // event(new Registered($user));
            DB::commit();
            return $user;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function resetPasswordUser(Request $request, $id)
    {
        try {
            $user_reset = $this->baseRepository->find($id);
            $type = $request->type;
            if ($type == 'DEFAULT') {
                $user_reset->forceFill([
                    'password' => Hash::make('eduquiz123@'),
                    'remember_token' => Str::random(60),
                ])->save();
                $password = 'eduquiz123@';
                event(new PasswordReset($user_reset));
            } else {
                $user_reset->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
                $password = $request->password;
                event(new PasswordReset($user_reset));
            }
            $data = [
                'user' => $user_reset,
                'password' => $password
            ];
            Notification::send($user_reset, new ResetPasswordUserNotification($data));
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function unBlockUser($id)
    {
        try {
            DB::beginTransaction();
            $user = $this->baseRepository->find($id);
            if ($user->status !== 'BLOCKED') {
                throw new ApiException('Tài khoản này không phải là tài khoản bị khóa', 500);
            }
            $user->forceFill([
                'status' => 'VERIFIED'
            ])->save();
            DB::commit();
            return $user;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    public function unBlockUserAll(Request $request)
    {
        try {
            $created_at = request()->query('created_at');
            $date = Carbon::parse($created_at);
            DB::beginTransaction();
            User::where('status','BLOCKED')
                ->whereDate('created_at','>=',$date)
                ->update(['status' => 'VERIFIED']);
            DB::commit();
            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('errors',[$exception->getFile(),$exception->getLine(),$exception->getMessage(),$created_at]);
        }
    }


    public function statisUserRegister(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $currentMonth = Carbon::now()->setDay(17)->setMonth($month)->setYear($year);
        $prevMonth = Carbon::now()->setDay(17)->setMonth($month)->setYear($year)->subMonth();
        $current = $this->baseRepository->getStatisUserByMonth($month, $year);
        $prev = $this->baseRepository->getStatisUserByMonth($prevMonth->month, $prevMonth->year);
        $data = [
            'current_month' => [
                'label' => $currentMonth->format('m/Y'),
                'data' => $current
            ],
            'prev_month' => [
                'label' => $prevMonth->format('m/Y'),
                'data' => $prev
            ]
        ];

        return $data;
    }
}

