<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            try{
                return route('login');

            }catch (RouteNotFoundException $exception){
                return response()->json(['error' => [
                    'status' => 401,
                    'message' =>'unauthenticated'
                ] ],401);
            }
        }
    }

    public function handle($request, \Closure $next, ...$guards)
    {
        if ($jwt = $request->cookie('jwt-staff')){
            $request->headers->set('Authorization', 'Bearer '. $jwt);
        }else if ($jwt = $request->cookie('jwt-client')){
            $request->headers->set('Authorization', 'Bearer '. $jwt);
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
}
