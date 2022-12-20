<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function PHPUnit\Framework\assertTrue;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderTestCase;
use Symfony\Component\Finder\SplFileInfo;

uses(PackageServiceProviderTestCase::class)->in('PackageServiceProviderTests');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/


function assertMigrationPublished(string $fileName)
{
    $published = collect(File::allFiles(database_path('migrations')))
        ->contains(function (SplFileInfo $file) use ($fileName) {
            return Str::endsWith($file->getPathname(), $fileName);
        });

    assertTrue($published);
}
