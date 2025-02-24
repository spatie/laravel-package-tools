<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/


use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderTestCase;

uses(PackageServiceProviderTestCase::class)->in('PackageServiceProviderTests');

/*
|--------------------------------------------------------------------------
| Expectations - move to Expectations.php once Laravel 9/Pest 1 is no longer supported
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Generic Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toHaveContentsMatching', function (string $contents) {
    expect($this->value)->toBeFile();
    expect(file_get_contents($this->value))->toBe($contents);

    return $this;
});

expect()->extend('toHaveContentsIncluding', function (string $contents) {
    expect($this->value)->toBeFile();
    expect(file_get_contents($this->value))->toContain($contents);

    return $this;
});

expect()->extend('toHaveContentsMatchingFile', function (string $filename) {
    expect($this->value)->toBeFile();
    expect($filename)->toBeFile();
    expect(file_get_contents($this->value))->toBe(file_get_contents($filename));

    return $this;
});

expect()->extend('toBeFileOrDirectory', function () {
    expect(is_file($this->value) || is_dir($this->value))->toBeTrue();

    return $this;
});

/*
|--------------------------------------------------------------------------
| Migration Expectations
|--------------------------------------------------------------------------
*/

/**
 * Check whether or not Migrations have been loaded
 * so that they will be run when the user does
 * a php artisan migrate
 **/

// expect("/path/to/migrations")->toHaveMigrationsLoaded(['list of', 'migrations expected', 'to be loaded'])
expect()->extend('toHaveMigrationsLoaded', function (...$testFiles) {
    $testFiles = collect($testFiles)->flatten()->toArray();
    $loadedFiles = getLoadedMigrations($this->value);
    $failures = [];

    foreach ($testFiles as $testFile) {
        if (! isFileListed($loadedFiles, $testFile . '.php', endsWith: true)) {
            $failures[] = $testFile;
        }
    }

    expect($failures)->toBeEmpty(
        "Migration(s) not loaded that should have been: " .
        var_export($failures, true) . PHP_EOL . "Loaded: " . var_export($loadedFiles, true)
    );

    return $this;
});

// expect("/path/to/migrations")->toHaveMigrationsNotLoaded(['list of', 'migrations expected', 'NOT to be loaded'])
expect()->extend('toHaveMigrationsNotLoaded', function (...$testFiles) {
    $testFiles = collect($testFiles)->flatten()->toArray();
    $loadedFiles = getLoadedMigrations($this->value);
    $failures = [];

    foreach ($testFiles as $testFile) {
        if (isFileListed($loadedFiles, $testFile, endsWith: false)) {
            $failures[] = $testFile;
        }
    }
    expect($failures)->toBeEmpty(
        "Migration(s) loaded that shouldn't have been: " .
        var_export($failures, true) . PHP_EOL . "Loaded: " . var_export($loadedFiles, true)
    );

    return $this;
});

function getLoadedMigrations(string $vendorMigrationPath): array
{
    $vendorMigrationPath = realpath($vendorMigrationPath) . DIRECTORY_SEPARATOR;

    return collect(app('migrator')->paths())
        ->map(function (string $file) use ($vendorMigrationPath): string {
            return Str::replace('\\', '/', Str::after(realpath($file), $vendorMigrationPath));
        })
        ->toArray();
}

/**
 * Check whether or not Migrations have been published from a package to user space
 * so that they will be run when the user does a php artisan migrate
 **/

expect()->extend('toHaveMigrationsPublished', function (...$testFiles) {
    $testFiles = collect($testFiles)->flatten()->toArray();
    $publishedFiles = getPublishedMigrations();
    $failures = [];

    foreach ($testFiles as $testFile) {
        if (! isFileListed($publishedFiles, $testFile . '.php', endsWith: true)) {
            $failures[] = $testFile;
        }
    }

    expect($failures)->toBeEmpty(
        "Migration(s) not published that should have been: " .
        var_export($failures, true) . PHP_EOL . "Published: " . var_export($publishedFiles, true)
    );

    return $this;
});

expect()->extend('toHaveMigrationsNotPublished', function (...$testFiles) {
    $testFiles = collect($testFiles)->flatten()->toArray();
    $publishedFiles = getPublishedMigrations();
    $failures = [];

    foreach ($testFiles as $testFile) {
        if (isFileListed($publishedFiles, $testFile, endsWith: false)) {
            $failures[] = $testFile;
        }
    }

    expect($failures)->toBeEmpty(
        "Migration(s) published that shouldn't have been: " .
        var_export($failures, true) . PHP_EOL . "Published: " . var_export($publishedFiles, true)
    );

    return $this;
});

function getPublishedMigrations(): array
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

function isFileListed(array $listedFiles, string $testFile, bool $endsWith): bool
{
    $fileName = basename($testFile);
    $filePath = substr($testFile, 0, -strlen($fileName) - 1);

    return arrayAny($listedFiles, function (string $file, int $ix) use ($filePath, $fileName, $endsWith) {
        $fileBase = basename($file);
        if (str_contains($file, '/') && substr($file, 0, -strlen($fileBase) - 1) != $filePath) {
            return false;
        }

        return $endsWith ? Str::endsWith($fileBase, $fileName) : Str::contains($fileBase, $fileName) ;
    });
}

// Local version of array_any delivered in PHP v8.4
// Once Laravel versions have left php 8.3 in the dust, this can be replaced by array_any
function arrayAny(array $array, callable $callback): bool
{
    foreach ($array as $key => $value) {
        if ($callback($value, $key)) {
            return true;
        }
    }

    return false;
}
