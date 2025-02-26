<?php

declare(strict_types=1);

/**
 * A replacement for the standard Pest `test` function that
 * rethrows a ServiceProvider exception which can be tested.
 *
 * This file needs to be loaded BEFORE the Pest Functions.php
 * and the only way to do that is to use PHP's auto_prepend_file
 *
 * Note: Pest v1/v2/v3 all have been confirmed to have identical definitions for test()
 * https://github.com/pestphp/pest/blob/1.x/src/Functions.php
 * https://github.com/pestphp/pest/blob/2.x/src/Functions.php
 * https://github.com/pestphp/pest/blob/3.x/src/Functions.php
 **/

use Pest\PendingObjects\TestCall;
use Pest\Support\Backtrace;
use Pest\Support\HigherOrderTapProxy;
use Pest\TestSuite;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\ServiceProvider;

function test(?string $description = null, ?Closure $closure = null): HigherOrderTapProxy|TestCall
{
    if ($description === null && TestSuite::getInstance()->test instanceof \PHPUnit\Framework\TestCase) {
        return new HigherOrderTapProxy(TestSuite::getInstance()->test);
    }

    $filename = Backtrace::testFile();

    // Create a wrapper for $closure that rethrows a saved exception during PackageServiceProvide register/boot
    $rethrower = function () use ($closure) {
        if (ServiceProvider::$thrownException) {
            throw ServiceProvider::$thrownException;
        }

        if ($closure) {
            Closure::bind($closure, $this)();
        }
    };

    return new TestCall(TestSuite::getInstance(), $filename, $description, $rethrower);
}
