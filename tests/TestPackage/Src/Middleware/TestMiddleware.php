<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Middleware;

use Closure;
use Illuminate\Http\Request;

class TestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request)->setContent('test-middleware-content');
    }
}
