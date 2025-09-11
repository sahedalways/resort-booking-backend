<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class Cors
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if (!$request->isMethod('OPTIONS')) {
            return $response;
        }
        $allow = $response->headers->get('Allow');
        if (!$allow) {
            return $response;
        }
        $headers = [
            'Access-Control-Allow-Methods' => $allow,
            'Access-Control-Max-Age' => 3600,
            'Access-Control-Allow-Headers' => 'X-Requested-With, Origin, X-Csrftoken, Content-Type, Accept',
        ];
        return $response->withHeaders($headers);
    }
}
