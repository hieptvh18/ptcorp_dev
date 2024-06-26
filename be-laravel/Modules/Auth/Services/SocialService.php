<?php

namespace Modules\Auth\Services;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Auth\Events\UserRegisterAfter;
use Modules\Auth\Models\UserInfo;

class SocialService
{

    protected $client;
    public function __construct()
    {
        $client = new Client();
        $this->client = $client;
    }

    /**
     * @param  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, $provider)
    {
        if ($provider == 'google') {
            return $this->checkGoogle($request->social_token);
        }

        if ($provider == 'facebook') {
            return $this->checkFacebook($request->social_token);
        }
    }

    /**
     * @param String $social_token
     * @return void
     */
    public function checkGoogle($social_token)
    {
        try {
            $checkToken = $this->client->get(config('auth.uri_get_token_google') . "$social_token");
            $responseGoogle = json_decode($checkToken->getBody()->getContents(), true);

            return $this->checkUserByEmail($responseGoogle);
        } catch (\Exception $e) {
            $data = [
                'message' => $e->getMessage()
            ];
            return $data;
        }
    }

    /**
     * @param String $social_token
     * @return void
     */
    public function checkFacebook($social_token)
    {
        try {
            $checkToken = $this->client->get(config('auth.uri_get_token_facebook') . "$social_token");
            $responseFacebook = json_decode($checkToken->getBody()->getContents(), true);
            return $this->checkUserByEmail($responseFacebook);
        } catch (\Exception $e) {
            $data = [
                'message' => $e->getMessage()
            ];
            return $data;
        }
    }

    /**
     * @param $profile
     * @return void
     */
    public function checkUserByEmail($profile)
    {
        $user = User::where('email', $profile['email'])->first();
        if (!$user) {

            $user_name = explode(" ", $profile['name']);
            $user = User::create([
                'username' => str_replace("-", "_", Str::slug($profile['name'])),
                'email' => $profile['email'],
                'password' => bcrypt(Str::random(8)),
            ]);
            $birthday = isset($profile['birthday']) ? date('Y-m-d', strtotime($profile['birthday'])) : null;
            $gender = isset($profile['gender']) ? $profile['gender'] : 'Male';
            $avatar_url = isset($profile['picture']) ? $profile['picture'] : null;
            UserInfo::create([
                'user_id' => $user->id,
                'first_name' => array_shift($user_name),
                'last_name' => array_pop($user_name),
                'birthday' => $birthday,
                'gender' => $gender,
                'avatar_url' => $avatar_url
            ]);

            event(new UserRegisterAfter($user));
        }
        $tokenResult = $user->createToken('authToken');
        $token_login = $tokenResult->plainTextToken;

        $data = [
            'access_token' => $token_login,
            'token_type' => 'Bearer',
        ];
        return $data;
    }
}
