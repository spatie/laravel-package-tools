<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

trait ProcessMigrations
{
    protected function bootPackageMigrations(): self
    {
        if ($this->package->discoversMigrations) {
            $this->discoverPackageMigrations();

            return $this;
        }

        $now = Carbon::now();

        foreach ($this->package->migrationFileNames as $migrationFileName) {
            $vendorMigration = $this->package->basePath("/../database/migrations/{$migrationFileName}.php");

            // Support for the .stub file extension
            if (! file_exists($vendorMigration)) {
                $vendorMigration .= '.stub';
            }

            if ($this->app->runningInConsole()) {
                $appMigration = $this->generateMigrationName($migrationFileName, $now->addSecond());

                $this->publishes(
                    [$vendorMigration => $appMigration],
                    "{$this->package->shortName()}-migrations"
                );
            }

            if ($this->package->runsMigrations) {
                $this->loadMigrationsFrom($vendorMigration);
            }
        }

        return $this;
    }

    protected function discoverPackageMigrations(): void
    {
        $now = Carbon::now();
        $migrationsPath = trim($this->package->migrationsPath, '/');

        $files = (new Filesystem())->files($this->package->basePath("/../{$migrationsPath}"));

        foreach ($files as $file) {
            $filePath = $file->getPathname();
            $isMigration = Str::endsWith($filePath, [".php", ".php.stub"]);

            // The publish destination is only needed when publishing, which happens
            // in the console. Generating it eagerly globs the application's migration
            // directory for every discovered file, so keep it out of the request path.
            if ($this->app->runningInConsole()) {
                $migrationFileName = Str::replace(['.stub', '.php'], '', $file->getFilename());

                // Publish but do not add timestamp to non migration files
                $appMigration = $isMigration
                    ? $this->generateMigrationName($migrationFileName, $now->addSecond())
                    : database_path("migrations/{$file->getFilename()}");

                $this->publishes(
                    [$filePath => $appMigration],
                    "{$this->package->shortName()}-migrations"
                );
            }

            // Do not load non migration files
            if ($this->package->runsMigrations && $isMigration) {
                $this->loadMigrationsFrom($filePath);
            }
        }
    }

    protected function generateMigrationName(string $migrationFileName, Carbon|CarbonImmutable $now): string
    {
        $migrationsPath = 'migrations/' . dirname($migrationFileName) . '/';
        $migrationFileName = basename($migrationFileName);

        $migrationFileName = self::stripTimestampPrefix($migrationFileName);

        $len = strlen($migrationFileName) + 4;

        if (Str::contains($migrationFileName, '/')) {
            $migrationsPath .= Str::of($migrationFileName)->beforeLast('/')->finish('/');
            $migrationFileName = Str::of($migrationFileName)->afterLast('/');
        }

        foreach (glob(database_path("{$migrationsPath}*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName . '.php')) {
                return $filename;
            }
        }

        $timestamp = $now->format('Y_m_d_His');
        $formattedFileName = Str::of($migrationFileName)->snake()->finish('.php');

        return database_path("{$migrationsPath}{$timestamp}_{$formattedFileName}");
    }

    private static function stripTimestampPrefix(string $filename): string
    {
        return preg_replace('/^\d{4}_\d{2}_\d{2}_\d{6}_/', '', $filename);
    }
}
