<?php

namespace App\Http\Middleware;

use Closure;

class AddContentLength
{
    public function handle($request, Closure $next) {
        $response = $next($request);
        $content_size = strlen(json_encode($response->getOriginalContent()));
        $response->header('Content-Length',$content_size);
        return $response;
    }
}
