<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Mockery\CountValidator\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
//        $this->middleware('jwt.auth', ['except' => ['authenticate','index','show']]);
    }
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

//    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
//    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function authenticate(Request $request)
    {
//        return "Hello";
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

//        return $credentials;
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }


    /*
     * Return All users
     */
    public function index(){
        return User::all();
    }

    /**
     * Get User Based ID using token
     */
    public function show(){
        try{
           $user =  JWTAuth::parseToken()->toUser();
            if(!$user){
                return $this->response->errorNotFound('User Not Found');
            }
        }catch (JWTException $ex){
            return $this->response->error('Token is invalid');
        }

        return $this->response->array(compact('user'))->setStatusCode(200);
    }

    /**
     * Refresh the Token back to client
     */
    public function getToken(){
        $token = JWTAuth::getToken();
        if(!$token){
            return $this->response->errorUnauthorized('Token is Invalid');
        }
        try{
            $refreshToken = JWTAuth::refresh($token);
        }catch (JWTException $ex){
            return $this->response->error('someThingWentWrong');
        }
        return $this->response->array(compact('refreshToken'));
    }

    public function delete(){
        $user = JWTAuth::parseToken()->authenticate();
//        return $user;
        if(!$user){
            return $this->response->error('system can not Recognize to User');
        }
        try{
            $result = $user->delete();
        }catch (JWTException $ex){
            return $this->response->error('someThingWentWrong');
        }
        return $this->response->json(['result'=>'User Has Been Deleted'])->getStatusCode(200);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


}
