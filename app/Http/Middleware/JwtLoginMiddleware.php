<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class JwtLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip kalau sudah login
        if (Auth::check()) {
            return $next($request);
        }

        $token = $request->query('token');

        if ($token) {
            try {
                $decoded = JWT::decode($token, new Key(env('JWT_AUTH_SECRET_KEY', 'Chelsea123!@#'), 'HS256'));

                // Validasi issuer
                if ($decoded->iss !== 'https://pg.concordreview.com') {
                    return response('Issuer tidak valid', 403);
                }

                // Cek user by email
                $email = $decoded->data->user->email ?? null;

                if ($email) {
                    $user = User::where('email', $email)->first();

                    if ($user) {
                        Auth::login($user);
                        return redirect($request->url()); // Hilangkan token dari URL
                    } else {
                        return response('Token tidak valid, user tidak ditemukan', 403);
                    }
                }

            } catch (\Exception $e) {
                return response('Token error: ' . $e->getMessage(), 403);
            }
        }
        return $next($request);
    }
}
