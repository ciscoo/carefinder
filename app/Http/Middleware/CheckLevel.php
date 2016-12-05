<?php

namespace App\Http\Middleware;

use Closure;
use App\Key;

class CheckLevel
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
        $auth = $request->header('x-auth-key');
        if (!$auth) {
            return response()->json([
                'error' => 'Missing x-auth-key header and a valid key.'
            ], 400);
        }

        $key = Key::where('secret', $auth)->first();
        if (!$key) {
            return response()->json([
                'error' => 'Invalid key.',
            ], 400);
        }

        if (!($key->level >= 2)) {
            return response()->json([
                'error' => 'Insufficient privileges.',
                'level' => $key->level
            ], 503);
        }
        
        return $next($request);
    }
}
