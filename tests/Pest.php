<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function PHPUnit\Framework\assertEmpty;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderTestCase;
use Symfony\Component\Finder\SplFileInfo;

uses(PackageServiceProviderTestCase::class)->in('PackageServiceProviderTests');

/*
|--------------------------------------------------------------------------
| Expectations - in Expectations.php
|--------------------------------------------------------------------------
*/
