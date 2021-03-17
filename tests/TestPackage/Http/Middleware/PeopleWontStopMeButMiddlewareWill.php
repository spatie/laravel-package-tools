<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class PeopleWontStopMeButMiddlewareWill
{
    /**
     * A tragic middleware who ends my hope.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($sorryMateYouCantGoAnyFurther = true) {
            abort(Response::HTTP_EXPECTATION_FAILED);
        }

        return $next($request);
    }
}
