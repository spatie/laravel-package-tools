<?php

declare(strict_types=1);

/**
 * A replacement for the standard Pest `test` function that
 * rethrows a TestServiceProvider exception which can be tested.
 *
 * This file needs to be loaded BEFORE the Pest Functions.php
 * and the only way to do that is to use PHP's auto_prepend_file
 *
 * Note: Pest v1/v2/v3 all have been confirmed to have identical definitions for test()
 * https://github.com/pestphp/pest/blob/1.x/src/Functions.php
 * https://github.com/pestphp/pest/blob/2.x/src/Functions.php
 * https://github.com/pestphp/pest/blob/3.x/src/Functions.php
 *
 * The only difference (which needed to be handled) was a change of namespace between v1 and v2+.
 **/

use Pest\Support\Backtrace;
use Pest\Support\HigherOrderTapProxy;
use Pest\TestSuite;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\TestServiceProvider;

function test(?string $description = null, ?Closure $closure = null): HigherOrderTapProxy|Pest\PendingCalls\TestCall|Pest\PendingObjects\TestCall
{
    if ($description === null && TestSuite::getInstance()->test instanceof \PHPUnit\Framework\TestCase) {
        return new HigherOrderTapProxy(TestSuite::getInstance()->test);
    }

    $filename = Backtrace::testFile();

    // Create a wrapper for $closure that rethrows a saved exception during PackageServiceProvide register/boot
    $rethrower = function () use ($closure) {
        if (TestServiceProvider::$thrownException) {
            throw TestServiceProvider::$thrownException;
        }

        if ($closure) {
            $closure->call($this);
        }
    };

    if (class_exists("Pest\PendingCalls\TestCall")) {
        // Pest v2/v3
        return new Pest\PendingCalls\TestCall(TestSuite::getInstance(), $filename, $description, $rethrower);
    } else {
        // Pest v1
        return new Pest\PendingObjects\TestCall(TestSuite::getInstance(), $filename, $description, $rethrower);
    }
}
