<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            return redirect()->route('login')->withErrors([
                'email' => 'Je hebt geen toegang tot deze pagina.',
            ]);
        }

        return $next($request);
    }
}
