<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $permission
     * @param $roles
     * @return mixed
     */
    public function handle($request, Closure $next, $permission, $roles = null)
    {
        if (\Auth::guest()) {
            return redirect('/');
        }

        if (! $request->user()->hasPermissionTo($permission)) {
            throw new AccessDeniedHttpException(trans('api.unauthorized'));
        }

        if ($roles){
            $roles = strpos($roles, '|') !== false ? explode('|', $roles) : $roles;
            if(! $request->user()->hasAnyRole($roles)) {
                throw new AccessDeniedHttpException(trans('api.unauthorized'));
            }
        }

        return $next($request);
    }
}
