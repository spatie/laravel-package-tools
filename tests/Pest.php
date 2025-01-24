<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function PHPUnit\Framework\assertFalse;
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

function assertMigrationPublished(string $fileName): void
{
    $files = getMigrationFiles();
    $published = is_migrationPublished($files, $fileName);

    if (! $published) {
        fwrite(STDERR, "assertMigrationPublished('{$fileName}'): " . var_export($files, true) . PHP_EOL);
    }
    assertTrue($published);
}

function assertMigrationNotPublished(string $fileName): void
{
    $files = getMigrationFiles();
    $published = is_migrationPublished($files, $fileName);

    if ($published) {
        fwrite(STDERR, "assertMigrationNotPublished('{$fileName}'): " . var_export($files, true) . PHP_EOL);
    }
    assertFalse($published);
}

function getMigrationFiles(): array {
    return array_map(
        function (string $fn) {
            return basename($fn);
        },
        glob(database_path('migrations/*.php'))
    );
}

function is_migrationPublished(array $files, string $fileName): bool {
    $fileName = basename($fileName);
    return array_any($files, function (string $file, int $ix) use ($fileName) {
            return Str::endsWith($file, $fileName);
        });
}