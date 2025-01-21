<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

trait ProcessMigrations
{
    protected function bootMigrations()
    {
        if ($this->package->discoversMigrations) {
            $this->discoverMigrations();

            return;
        }

        $now = Carbon::now();

        foreach ($this->package->migrationFileNames as $migrationFileName) {
            $vendorMigration = $this->package->basePath("/../database/migrations/{$migrationFileName}.php");
            $appMigration = $this->generateMigrationName($migrationFileName, $now->addSecond());

            // Support for the .stub file extension
            if (! file_exists($vendorMigration)) {
                $vendorMigration .= '.stub';
            }

            if ($this->app->runningInConsole()) {
                $this->publishes(
                    [$vendorMigration => $appMigration],
                    "{$this->package->shortName()}-migrations"
                );
            }

            if ($this->package->runsMigrations) {
                $this->loadMigrationsFrom($vendorMigration);
            }
        }
    }

    protected function discoverMigrations()
    {
        $now = Carbon::now();
        $migrationsPath = trim($this->package->migrationsPath, '/');

        $files = (new Filesystem())->files($this->package->basePath("/../{$migrationsPath}"));

        foreach ($files as $file) {
            $filePath = $file->getPathname();
            $migrationFileName = Str::replace(['.stub', '.php'], '', $file->getFilename());

            $appMigration = $this->generateMigrationName($migrationFileName, $now->addSecond());

            if ($this->app->runningInConsole()) {
                $this->publishes(
                    [$filePath => $appMigration],
                    "{$this->package->shortName()}-migrations"
                );
            }

            if ($this->package->runsMigrations) {
                $this->loadMigrationsFrom($filePath);
            }
        }
    }

    protected function generateMigrationName(string $migrationFileName, Carbon $now): string
    {
        $migrationsPath = 'migrations/'.dirname($migrationFileName).'/';
        $migrationFileName = basename($migrationFileName);

        $len = strlen($migrationFileName) + 4;

        if (Str::contains($migrationFileName, '/')) {
            $migrationsPath .= Str::of($migrationFileName)->beforeLast('/')->finish('/');
            $migrationFileName = Str::of($migrationFileName)->afterLast('/');
        }

        foreach (glob(database_path("{$migrationsPath}*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName.'.php')) {
                return $filename;
            }
        }

        $timestamp = $now->format('Y_m_d_His');
        $migrationFileName = Str::of($migrationFileName)->snake()->finish('.php');

        return database_path($migrationsPath.$timestamp.'_'.$migrationFileName);
    }
}
