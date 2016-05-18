<?php

namespace Sidep\Http\Middleware;

use Closure;

class UsuarioC3Autenticado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // debe haber un usuario logueado
        if (is_null($request->session()->get('encargo'))) {
            return redirect('admin/login');
        }

        return $next($request);
    }
}
