<?php

namespace App\Http\Middleware;

use App\User;
use App\Support\TenantConnector;
use Closure;

class Tenant {

    use TenantConnector;

    /**
     * @var User
     */
    protected $user;

    /**
     * Tenant constructor.
     * @param User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        
        if (($request->session()->get('tenant')) === null){
            // return redirect()->route('home')->withErrors(['error' => 'Tenant db not connected']);
        }
        
        $user = User::find(1);

        $this->reconnect($user);

        return $next($request);
    }
}