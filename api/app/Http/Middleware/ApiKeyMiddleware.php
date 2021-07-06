<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $key = $request->header('key');
        if ($key != env('api', 'qNBC!GvgpFHJNVLmD7su')) {
            return response('Unauthorized', 401);
        }

        return $next($request);
    }
}
