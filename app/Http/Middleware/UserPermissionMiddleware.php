<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $permission_slug)
    {
        $permission = Permission::query()
            ->where('slug', $permission_slug)
            ->first();

        if(!$permission) {
            throw new HttpResponseException(response()->json([
                'error' => [
                    'code' => 500,
                    'message' => 'Таких прав не существует!'
                ]
            ], 500));
        }

        if(!Auth::check()) {
            throw new HttpResponseException(response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'Не авторизован!'
                ]
            ], 401));
        }

        if(!Auth::user()->hasPermissionTo($permission)) {
            throw new HttpResponseException(response()->json([
                'error' => [
                    'code' => 403,
                    'message' => 'У вас нет прав для выполнения этой операции!'
                ]
            ], 403));
        }

        return $next($request);
    }
}
