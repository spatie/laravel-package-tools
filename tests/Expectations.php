<?php

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

// expect("/path/to/migrations")->toHaveExpectedMigrationsLoaded(['list of', 'migrations expected', 'to be loaded'])
expect()->extend('toHaveExpectedMigrationsLoaded', function (...$expectedFiles) {
    expect($this->value)->toBeDirectory();
    $expectedFiles = collect($expectedFiles)->flatten()->toArray();
    $loadedFiles = getLoadedMigrations($this->value);
    $failures = [];

    foreach ($expectedFiles as $expectedFile) {
        if (! isFileListed($loadedFiles, $expectedFile, endsWith: false)) {
            $failures[] = $expectedFile;
        }
    }

    expect($failures)->toBeEmpty(
        "Migration(s) not loaded that should have been: " .
        var_export($failures, true) . PHP_EOL . "Loaded: " . var_export($loadedFiles, true)
    );

    return $this;
});

// expect("/path/to/migrations")->toHaveOnlyExpectedMigrationsLoaded(['list of', 'migrations expected', 'to be loaded'])
expect()->extend('toHaveOnlyExpectedMigrationsLoaded', function (...$expectedFiles) {
    expect($this->value)->toBeDirectory();
    $migrationFiles = getDirectoryContents($this->value);
    $expectedFiles = collect($expectedFiles)->flatten()->toArray();
    $loadedFiles = getLoadedMigrations($this->value);
    $failures = [];

    foreach ($migrationFiles as $migrationFile) {
        $migrationFile = Str::before($migrationFile, '.php');

        if (in_array($migrationFile, $expectedFiles)) {
            continue;
        }

        if (isFileListed($loadedFiles, $migrationFile, endsWith: false)) {
            $failures[] = $migrationFile;
        }
    }

    expect($failures)->toBeEmpty(
        "Migration(s) loaded that shouldn't have been: " .
        var_export($failures, true) . PHP_EOL . "Expected: " . var_export($expectedFiles, true)
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

// expect("/path/to/migrations")->toHaveExpectedMigrationPublished(['list of', 'migrations expected', 'to be published'])
expect()->extend('toHaveExpectedMigrationsPublished', function (...$expectedFiles) {
    $expectedFiles = collect($expectedFiles)->flatten()->toArray();
    $publishedFiles = getDirectoryContents(database_path("migrations"));
    $failures = [];

    foreach ($expectedFiles as $expectedFile) {
        if (! isFileListed($publishedFiles, $expectedFile, endsWith: false)) {
            $failures[] = $expectedFile;
        }
    }

    expect($failures)->toBeEmpty(
        "Migration(s) not published that should have been: " .
        var_export($failures, true) . PHP_EOL . "Published: " . var_export($publishedFiles, true)
    );

    return $this;
});

// expect("/path/to/migrations")->toHaveOnlyExpectedMigrationPublished(['list of', 'migrations expected', 'to be published'])
expect()->extend('toHaveOnlyExpectedMigrationsPublished', function (...$expectedFiles) {
    expect($this->value)->toBeDirectory();
    $migrationFiles = getDirectoryContents($this->value);
    $expectedFiles = collect($expectedFiles)->flatten()->toArray();
    $publishedFiles = getDirectoryContents(database_path("migrations"));
    $failures = [];

    foreach ($migrationFiles as $migrationFile) {
        $migrationFile = Str::before($migrationFile, '.php');
        if (in_array($migrationFile, $expectedFiles)) {
            continue;
        }

        if (isFileListed($publishedFiles, $migrationFile, endsWith: false)) {
            $failures[] = $migrationFile;
        }
    }

    expect($failures)->toBeEmpty(
        "Migration(s) published that shouldn't have been: " .
        var_export($failures, true) . PHP_EOL . "Expected: " . var_export($expectedFiles, true)
    );

    return $this;
});

function getDirectoryContents(string $path): array
{
    $path = realpath($path) . DIRECTORY_SEPARATOR;

    return collect(File::allFiles($path))
        ->map(function (SplFileInfo $file) use ($path): string {
            return Str::replace('\\', '/', Str::after(realpath($file->getPathname()), $path));
        })
        ->toArray();
}

/*
* Utility functions
*/

function isFileListed(array $listedFiles, string $expectedFile, bool $endsWith): bool
{
    $fileName = basename($expectedFile);
    $filePath = substr($expectedFile, 0, -strlen($fileName) - 1);

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
