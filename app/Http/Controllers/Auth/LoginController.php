<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

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
    // protected $redirectTo = '/users';
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Registrar login en bitácora
        try {
            $roles = $user->getRoleNames()->implode(', ');
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Inicio de Sesión',
                'description' => "{$user->name} ({$roles}) inició sesión en el sistema",
                'ip_address' => $request->ip() ?? 'No disponible',
                'browser' => $request->header('User-Agent') ?? 'No disponible',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al registrar login en bitácora: ' . $e->getMessage());
        }
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        // Registrar logout en bitácora
        try {
            $user = Auth::user();
            if ($user) {
                $roles = $user->getRoleNames()->implode(', ');
                ActivityLog::create([
                    'user_id' => $user->id,
                    'action' => 'Cierre de Sesión',
                    'description' => "{$user->name} ({$roles}) cerró sesión",
                    'ip_address' => $request->ip() ?? 'No disponible',
                    'browser' => $request->header('User-Agent') ?? 'No disponible',
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error al registrar logout en bitácora: ' . $e->getMessage());
        }
    }
}
