<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        // Cek jika user tidak ada atau role tidak sesuai syarat
        if (!$user || $user->role !== $role) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Unauthorized. Role ' . $role . ' required.'
            ], 403); // Return 403 JSON
        }

        return $next($request);
    }
}