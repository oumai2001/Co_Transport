<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            return redirect('/login')->with('error', 'Veuillez vous connecter');
        }
        
        if ($_SESSION['user_role'] !== $role) {
            abort(403, 'Accès non autorisé');
        }
        
        return $next($request);
    }
}