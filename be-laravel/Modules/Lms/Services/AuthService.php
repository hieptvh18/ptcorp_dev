<?php

namespace Modules\Lms\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AuthService
{
    public function createAccount($member)
    {
        try {
            $wp_alias = request()->header('workspace');
            DB::beginTransaction();
            $response = Http::post(config('lms.service_url.auth')."/auth/api/public/v1/create-account", [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'wp_alias' => $wp_alias,
                'first_name' => $member->firstname,
                'last_name' => $member->lastname,
                'birth_day' => $member->birth_day,
                'mobile' => $member->mobile ?? '0989999999',
                'email' => $member->email,
                'user_type' => 'STUDENT',
            ]);
            $data = json_decode($response->getBody()->getContents());
            $member->update([
                'user_id' => $data->success->user->id
            ]);
            DB::commit();
            return $data->success;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function attachTeamWork($user_id){
        try{
            DB::beginTransaction();
            $wp_alias = request()->header('workspace');
            $token = request()->header('Authorization');
            Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $token
            ])->post(config('lms.service_url.auth')."/auth/api/user/v1/workspace-info/$wp_alias/members/attach-team", [
                'user_id' => $user_id,
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            throw $e;
        }
    }

}
