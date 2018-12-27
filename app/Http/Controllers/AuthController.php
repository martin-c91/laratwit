<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class AuthController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = \Laravel\Passport\Client::where('password_client', 1)->first();
    }

    function register(Request $request)
    {
        /**
         * Get a validator for an incoming registration request.
         *
         * @param  array  $request
         * @return \Illuminate\Contracts\Validation\Validator
         */
        $valid = validator($request->json()->all(), [
            'name' => 'required|string|max:20',
            'slug' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'description' => 'text|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($valid->fails()) {
            $jsonError=response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }

        $data = request()->json()->all();

        User::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'username'      => $data['slug'],
            'password'      => $data['password'],
            'scope'         => null,
        ]);

        $token = Request::create(
            'oauth/token',
            'POST'
        );
        return \Route::dispatch($token);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function login(Request $request)
    {
        $request->request->add([
            'grant_type' => 'password',
            //passport take in username param thus:
            'username' => $request->username,
            'password' => $request->password,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function refreshToken(Request $request)
    {
        $request->request->add([
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }

    public function user(Request $request)
    {
        return $request->user('api')->append('isFollowing');
    }

    public function logout(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(["message" => "successfully logged out"]);
    }
}
