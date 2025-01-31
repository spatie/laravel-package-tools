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
| Expectations
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

/*
* Check whether migrations have or haven't been LOADED
*/

function assertMigrationsLoaded(string $vendorMigrationPath, ...$testFiles): void
{
    $testFiles = collect($testFiles)->flatten()->toArray();
    $loadedFiles = get_loaded_migrations($vendorMigrationPath);
    $failures = [];
    foreach ($testFiles as $testFile) {
        if (! is_file_listed($loadedFiles, $testFile . '.php', endsWith: true)) {
            $failures[] = $testFile;
        }
    }
    assertEmpty($failures, "Migration(s) not loaded that should have been: " .
        var_export($failures, true) . PHP_EOL . "Loaded: " . var_export($loadedFiles, true));

}

function assertMigrationsNotLoaded(string $vendorMigrationPath, ...$testFiles): void
{
    $testFiles = collect($testFiles)->flatten()->toArray();
    $loadedFiles = get_loaded_migrations($vendorMigrationPath);
    $failures = [];
    foreach ($testFiles as $testFile) {
        if (is_file_listed($loadedFiles, $testFile, endsWith: false)) {
            $failures[] = $testFile;
        }
    }
    assertEmpty($failures, "Migration(s) loaded that shouldn't have been: " .
        var_export($failures, true) . PHP_EOL . "Loaded: " . var_export($loadedFiles, true));
}

function get_loaded_migrations(string $vendorMigrationPath): array
{
    $vendorMigrationPath = realpath($vendorMigrationPath) . DIRECTORY_SEPARATOR;

    return collect(app('migrator')->paths())
        ->map(function (string $file) use ($vendorMigrationPath): string {
            return Str::replace('\\', '/', Str::after(realpath($file), $vendorMigrationPath));
        })
        ->toArray();
}

/*
* Check whether migrations have or haven't been artisan PUBLISHED
*/

function assertMigrationsPublished(...$testFiles): void
{
    $testFiles = collect($testFiles)->flatten()->toArray();
    $publishedFiles = get_published_migrations();
    $failures = [];
    foreach ($testFiles as $testFile) {
        if (! is_file_listed($publishedFiles, $testFile . '.php', endsWith: true)) {
            $failures[] = $testFile;
        }
    }
    assertEmpty($failures, "Migration(s) not published that should have been: " .
        var_export($failures, true) . PHP_EOL . "Published: " . var_export($publishedFiles, true));
}

function assertMigrationsNotPublished(...$testFiles): void
{
    $testFiles = collect($testFiles)->flatten()->toArray();
    $publishedFiles = get_published_migrations();
    $failures = [];
    foreach ($testFiles as $testFile) {
        if (is_file_listed($publishedFiles, $testFile, endsWith: false)) {
            $failures[] = $testFile;
        }
    }
    assertEmpty($failures, "Migration(s) published that shouldn't have been: " .
        var_export($failures, true) . PHP_EOL . "Published: " . var_export($publishedFiles, true));
}

function get_published_migrations(): array
{
    $databasePath = realpath(database_path("migrations")) . DIRECTORY_SEPARATOR;

    return collect(File::allfiles($databasePath))
        ->map(function (SplFileInfo $file) use ($databasePath): string {
            return Str::replace('\\', '/', Str::after(realpath($file->getPathname()), $databasePath));
        })
        ->toArray();
}

/*
* Utility functions
*/

function is_file_listed(array $listedFiles, string $testFile, bool $endsWith): bool
{
    $fileName = basename($testFile);
    $filePath = substr($testFile, 0, -strlen($fileName) - 1);

    return local_array_any($listedFiles, function (string $file, int $ix) use ($filePath, $fileName, $endsWith) {
        $fileBase = basename($file);
        if (str_contains($file, '/') && substr($file, 0, -strlen($fileBase) - 1) != $filePath) {
            return false;
        }

        return $endsWith ? Str::endsWith($fileBase, $fileName) : Str::contains($fileBase, $fileName) ;
    });
}

function local_array_any(array $array, callable $callback): bool
{
    foreach ($array as $key => $value) {
        if ($callback($value, $key)) {
            return true;
        }
    }

    return false;
}
