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
        // Checking if required header is set.
        if (!$request->header('X-Auth-Key')) {
            return response()->json([
                'error' => 'Missing X-Auth-Key header.'
            ], 400);
        }

        // Checking if Key exists with a given secret.
        $key = Key::where('secret', $request->header('X-Auth-Key'))->first();
        if (!$key) {
            return response()->json([
                'error' => 'Invalid key.',
            ], 400);
        }
        
        // Checking if the current requested route requires admin privileges.
        if (!array_key_exists('level', $request->route()->getAction()) && !($key->level >= 2)) {
            return response()->json([
                'error' => 'Insufficient privileges.'
            ], 401);
        }
        
        return $next($request);        
    }
}
