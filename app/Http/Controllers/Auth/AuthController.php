<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegistrationCompleted;
use App\Events\ConfirmationNeeded;
use App\Exceptions\NoActiveAccountException;
use App\Http\AuthTraits\Social\ManagesSocialAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Illuminate\Auth\Events\Registered;


class AuthController extends RegisterController
{
    use AuthenticatesUsers, ManagesSocialAuth;

    protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout',
            'redirectToProvider',
            'handleProviderCallback']
        ]);
    }

    private function checkStatusLevel()
    {
        if ( ! Auth::user()->isActiveStatus()) {
            Auth::logout();
            throw new NoActiveAccountException;
        }
    }

    public function redirectPath()
    {
        if (Auth::user()->isAdmin()){
            return 'admin';
        }
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        
        if ($this->attemptLogin($request)) {

            $this->checkStatusLevel();

            return $this->sendLoginResponse($request);
        }
        
        if (!$this->checkCredential($request)) {
            
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }

    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // create the User

        $user = $this->create($request->all());
        
        event(new Registered($user));
        
        if(env('REQUIRE_EMAIL_CONFIRMATION', 0)) {
            
            $user->confirmed = false;
            $user->confirmation_code = str_random(30);
            $user->save();

            event(new ConfirmationNeeded($user));

            return back()->with('confirmation-success', trans('confirmation.message'));
        }
        else {
            
            // Log the User in

            $this->guard()->login($user);

            event(new RegistrationCompleted($user));

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());
        }
    }
    
    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        
        if(env('REQUIRE_EMAIL_CONFIRMATION', 0)) {
            
            $user = Auth::user();
            
            if ($user->confirmed) {
                
                // If user is confirmed we make the login and delete session information if needed
                if ($request->session()->has('user_id')) {
                    
                    $request->session()->forget('user_id');
                }

            }
            else {
                
                Auth::logout();
                
                $request->session()->put('user_id', $user->id);

                return back()->with('confirmation-danger', __('confirmation.again'));

            }
        }

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }


    /**
     * Check credential.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    protected function checkCredential($request)
    {
        return $this->guard()->validate($this->credentials($request));
    }
}
