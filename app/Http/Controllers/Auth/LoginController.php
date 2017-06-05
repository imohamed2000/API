<?php

namespace App\Http\Controllers\Auth;

use App\Beak\Response;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $response;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->response = new Response;

        $this->middleware('jwt_auth')->only(['logout']);
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Beak\Response
     */
    public function login(Request $request)
    {   

        // Data validation
        $rules = [
            'email'     => 'required|email',
            'password'  => 'required'
        ];
        $is_valid = $this->validate($request->all(), $rules );

        if(!$is_valid)
        {
            return $this->response->badRequest( $this->errors )->respond();
        }

        // using the ThrottlesLogins trait 
        // to throttle the login attempts for this application

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Creating custom claims for auth tokens
        // Extending the expiration date with 2 weeks if remember me is set.
        // The default ttl is one hour.
        // 
        $custom_claims = [];
        $exp = new \DateTime('+1 hour');

        if($request->has('remember'))
        {   
            $exp = new \DateTime('+2 week');
            $custom_claims['exp'] = $exp->getTimestamp();
        }

        // Creating the JWT auth token
        try {
           if( $token = JWTAuth::attempt( $request->only('email','password'), $custom_claims ) )
           {
                $this->clearLoginAttempts($request);

                return $this->response
                            ->created(['token'  => $token])
                            ->withTokenCookie($token, $exp->getTimestamp())
                            ->respond();
           }

        } catch (JWTException $e) {
            return $this->respond->serverError('Could not create token!')->respond();
        }

        // Increment login attempts if login faild
        $this->incrementLoginAttempts($request);

        // Create response errorr messages
        $errors = collect([]);
        $email_exists = \App\User::where('email', $request->email)->first();
        if(!$email_exists)
        {
            $errors->put('email', "We couldn't find your email");
        }else
        {
            $errors->put('password', 'You entered a wrong password');
        }

        return $this->response->badRequest($errors)->respond();
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Beak\Response
     */
    public function logout(Request $request)
    {   
        // invalidate token 
        $token = JWTAuth::parseToken()->getToken();
        JWTAuth::invalidate($token);

        // remove token from cookies and return response
        $exp = new \Datetime();
        return $this->response->ok(['token' => ''])
                                ->withTokenCookie('', $exp->getTimestamp() )
                                ->respond();
    }
}
