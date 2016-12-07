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
        $auth = $request->header('X-Auth-Key');
        if (!$auth) {
            return response()->json([
                'error' => 'Missing X-Auth-Key header.'
            ], 400);
        }

        $key = Key::where('secret', $auth)->first();
        if (!$key) {
            return response()->json([
                'error' => 'Invalid key.',
            ], 400);
        }
        
        if (!array_key_exists('level', $request->route()->getAction()) && !($key->level >= 2)) {
            return response()->json([
                'error' => 'Insufficient privileges.'
            ], 401);
        }
        
        return $next($request);        
    }
}
