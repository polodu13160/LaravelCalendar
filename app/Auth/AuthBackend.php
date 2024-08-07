<?php

namespace App\Auth;

use App\Models\User;
use Sabre\HTTP\Auth\Basic;
use Sabre\HTTP\Auth\Bearer;
use Sabre\HTTP\RequestInterface;
use Sabre\HTTP\ResponseInterface;
use App\Http\Services\LaravelSabre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Sabre\DAV\Auth\Backend\BackendInterface;

class AuthBackend implements BackendInterface
{
    /**
     * Authentication Realm.
     *
     * The realm is often displayed by browser clients when showing the
     * authentication dialog.
     *
     * @var string
     */
    protected $realm;

    public function __construct()
    {
        $this->realm = config('app.realm');
    }

    /**
     * Sets the authentication realm for this backend.
     *
     * @param  string  $realm
     * @return void
     */
    public function setRealm($realm)
    {
        $this->realm = $realm;
    }

    /**
     * Check Laravel authentication.
     *
     * @psalm-suppress NoInterfaceProperties
     *
     * @return array
     */
    public function check(RequestInterface $request, ResponseInterface $response)
    {
        /** @var \Illuminate\Foundation\Auth\User|null */
        // if (LaravelSabre::check($request)){
        //  $user = Auth::user();
        // if (is_null($user)) {
        //     return [false, 'User is not authenticated'];
        // }

        // return [true, 'principals/'.$user->email];
        // }
        // return [false, 'User is not authenticated'];
        $authBearer = new Bearer($this->realm, $request, $response);
        $token = $authBearer->getToken();

        if ($token && $this->validateGlobalToken($token)) {
            return [true, 'principals/global'];
        }

        $authbasic = new \Sabre\HTTP\Auth\Basic(
            $this->realm,
            $request,
            $response
        );
        $userpass = $authbasic->getCredentials();

        if ($userpass) {
            $user = $this->validateUserPass($userpass[0], $userpass[1]);
            if ($user) {
                return [true, 'principals/' . $user->email];
            }
        }
        return [false, 'User is not authenticated'];
    }

    /**
     * This method is called when a user could not be authenticated, and
     * authentication was required for the current request.
     *
     * This gives you the opportunity to set authentication headers. The 401
     * status code will already be set.
     *
     * In this case of Bearer Auth, this would for example mean that the
     * following header needs to be set:
     *
     * $response->addHeader('WWW-Authenticate', 'Bearer realm=SabreDAV');
     *
     * Keep in mind that in the case of multiple authentication backends, other
     * WWW-Authenticate headers may already have been set, and you'll want to
     * append your own WWW-Authenticate header instead of overwriting the
     * existing one.
     *
     * @return void
     */
    public function challenge(RequestInterface $request, ResponseInterface $response)
    {

        $authBearer = new Bearer($this->realm, $request, $response);
        $authBearer->requireLogin();

        $authBasic = new Basic($this->realm, $request, $response);
        $authBasic->requireLogin();

    }
    protected function validateGlobalToken($token)
    {
        return $token === config('app.global_api_token');
    }





    protected function validateUserPass($username, $password)
    {
        // Find the user by email
        $user = User::where('email', $username)->first();

        if (!$user) {
            return false;
        }

        // Verify the password
        return Hash::check($password, $user->password) ? $user : false;
    }
}
