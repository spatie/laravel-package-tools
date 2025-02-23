<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

use Symfony\Component\Finder\SplFileInfo;

trait ProcessMigrations
{
    protected function bootPackageMigrations(): self
    {
        if ($this->package->discoversMigrations) {
            if (! empty($this->package->migrationFileNames)) {
                throw InvalidPackage::conflictingMethods(
                    $this->package->name,
                    'hasMigrations',
                    'discoversMigrations'
                );
            }

            $this->package->migrationFileNames = self::convertDiscovers($this->package->migrationsPath());
        }

        if (empty($this->package->migrationFileNames)) {
            return $this;
        }

        $now = Carbon::now();
        $vendorPath = $this->package->migrationsPath();
        foreach ($this->package->migrationFileNames as $migrationFileName) {
            $vendorMigration = $this->phpOrStub("{$vendorPath}/{$migrationFileName}");
            if (! $vendorMigration) {
                continue;
            }

            $appMigration = $this->generateMigrationName($migrationFileName . '.php', $now->addSecond());

            if ($this->app->runningInConsole()) {
                $this->publishes(
                    [$vendorMigration => database_path("migrations/{$appMigration}")],
                    "{$this->package->shortName()}-migrations"
                );
            }

            /**
             * Laravel will only load files ending in .php so we cannot load .stub files for migration
             * https://github.com/laravel/framework/blob/11.x/src/Illuminate/Database/Migrations/Migrator.php#L540
             **/
            if ($this->package->loadMigrations && str_ends_with($vendorMigration, '.php')) {
                $this->loadMigrationsFrom($vendorMigration);
            }
        }

        return $this;
    }

    protected function generateMigrationName(string $migrationFileName, Carbon $now): string
    {
        $migrationPath = dirname($migrationFileName);
        if ($migrationPath) {
            $migrationPath .= '/';
        }
        $migrationFileName = Str::of(basename($migrationFileName))->snake()->finish('.php');

        foreach (glob(database_path("migrations/{$migrationPath}*{$migrationFileName}.php")) as $existing) {
            $existing = Str::after($existing, database_path('migrations'));
            if (Str::endsWith($existing, $migrationFileName)) {
                return $existing;
            }
        }

        $timestamp = $now->format('Y_m_d_His_');

        return $migrationPath . $timestamp . $migrationFileName;
    }

    protected static function convertDiscovers(string $path): array
    {
        return collect(File::allfiles($path))->map(function (SplFileInfo $file) use ($path): string {
            $relativePath = Str::after($file->getPathname(), $path);
            foreach ([".stub", ".php"] as $suffix) {
                if (str_ends_with($relativePath, $suffix)) {
                    $relativePath = substr($relativePath, 0, -strlen($suffix));
                }
            }

            return $relativePath;
        })->toArray();
    }
}
