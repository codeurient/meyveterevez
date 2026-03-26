<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check IP allowlist first (return 404 — never reveal admin exists)
        $allowedIps = config('admin.allowed_ips');
        if ($allowedIps) {
            $ips = array_map('trim', explode(',', $allowedIps));
            if (! in_array($request->ip(), $ips)) {
                abort(404);
            }
        }

        // Must be authenticated
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Must be admin role (return 404 — never confirm admin panel exists to non-admins)
        if (! auth()->user()->isAdmin()) {
            abort(404);
        }

        return $next($request);
    }
}
