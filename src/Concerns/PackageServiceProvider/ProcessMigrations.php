<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

trait ProcessMigrations
{
    protected Carbon $now;

    protected function bootPackageMigrations(): self
    {
        if (! $this->app->runningInConsole()) {
            return $this;
        }

        $this->now = Carbon::now();

        return $this
            ->bootPublishMigrationsByName()
            ->bootPublishMigrationsByPath()
            ->bootPublishMigrationsByDiscovers()
            ->bootLoadMigrationsByName()
            ->bootLoadMigrationsByPath()
            ->bootLegacyLoadPublishedMigrationsByName()
            ->bootLegacyLoadPublishedMigrationsByDiscovers();
    }

    protected function bootPublishMigrationsByName(): self
    {
        return $this->bootPublishMigrationsCommon($this->package->migrationsByNamePath(), $this->package->migrationPublishesNames);
    }

    protected function bootPublishMigrationsByPath(): self
    {
        return $this->bootPublishMigrationsByPathCommon($this->package->migrationPublishesPaths);
    }

    protected function bootPublishMigrationsByDiscovers(): self
    {
        return $this->bootPublishMigrationsByPathCommon($this->package->migrationDiscoversPaths);
    }

    protected function bootLoadMigrationsByName(): self
    {
        return $this->bootLoadMigrationsCommon($this->package->migrationsByNamePath(), $this->package->migrationLoadsNames);
    }

    protected function bootLoadMigrationsByPath(): self
    {
        return $this->bootLoadMigrationsByPathCommon($this->package->migrationLoadsPaths);
    }

    protected function bootLegacyLoadPublishedMigrationsByName(): self
    {
        if (! $this->package->migrationLegacyLoadsPublished || ! $this->package->migrationPublishesNames) {
            return $this;
        }

        /* We only want to load published migrations that are .php files and not in the explicitly published names */
        return $this->bootLoadMigrationsCommon(
            $this->package->migrationsByNamePath(),
            array_diff($this->package->migrationPublishesNames, $this->package->migrationLoadsNames)
        );
    }

    protected function bootLegacyLoadPublishedMigrationsByDiscovers(): self
    {
        if (! $this->package->migrationLegacyLoadsPublished || ! $this->package->migrationDiscoversPaths) {
            return $this;
        }

        return $this->bootLoadMigrationsByPathCommon($this->package->migrationDiscoversPaths);
    }

    protected function convertPathToNames(string $path): array
    {
        $path .= DIRECTORY_SEPARATOR;

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

    protected function bootLoadMigrationsByPathCommon(array $paths): self
    {
        foreach ($paths as $path) {
            $path = $this->package->basePath($path);
            $this->bootLoadMigrationsCommon($path, $this->convertPathToNames($path));
        }

        return $this;
    }

    protected function bootPublishMigrationsByPathCommon(array $paths): self
    {
        foreach ($paths as $path) {
            $path = $this->package->basePath($path);
            $this->bootPublishMigrationsCommon($path, $this->convertPathToNames($path));
        }

        return $this;
    }

    protected function bootLoadMigrationsCommon(string $vendorPath, array $migrationLoadsNames): self
    {
        if (empty($migrationLoadsNames)) {
            return $this;
        }

        foreach ($migrationLoadsNames as $migrationFileName) {
            $vendorMigration = $this->phpOrStub("{$vendorPath}/{$migrationFileName}");
            if (! $vendorMigration) {
                continue;
            }

            /**
             * Laravel will only load files ending in .php so we cannot load .stub files for migration
             * https://github.com/laravel/framework/blob/11.x/src/Illuminate/Database/Migrations/Migrator.php#L540
             **/
            if (str_ends_with($vendorMigration, '.php')) {
                $this->loadMigrationsFrom($vendorMigration);
            }
        }

        return $this;
    }

    protected function bootPublishMigrationsCommon(string $vendorPath, array $migrationPublishesNames): self
    {
        if (empty($migrationPublishesNames)) {
            return $this;
        }

        foreach ($migrationPublishesNames as $migrationFileName) {
            $vendorMigration = $this->phpOrStub("{$vendorPath}/{$migrationFileName}");
            if (! $vendorMigration) {
                continue;
            }

            $appMigration = $this->generateMigrationName($migrationFileName . '.php');

            $this->publishes(
                [$vendorMigration => database_path("migrations/{$appMigration}")],
                "{$this->package->shortName()}-migrations"
            );
        }

        return $this;
    }

    protected function generateMigrationName(string $migrationFileName): string
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

        return $migrationPath . $this->now->addSecond()->format('Y_m_d_His_') . $migrationFileName;
    }
}
