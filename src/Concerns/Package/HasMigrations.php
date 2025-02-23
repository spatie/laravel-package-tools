<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasMigrations
{

    public array $migrationFileNames = [];
    public bool $loadMigrations = false;
    public bool $discoversMigrations = false;
    public array $migrationPaths = [];
    protected ?string $migrationsPath = '/../database/migrations';

    public function hasMigrationsByName(...$migrationFileNames): self
    {
        $this->migrationFileNames = array_merge(
            $this->migrationFileNames,
            collect($migrationFileNames)->flatten()->toArray()
        );

        $this->migrationsPath = $this->verifyDirOrNull($this->migrationsPath);

        return $this;
    }

    public function migrationsPath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->migrationsPath, $directory);
    }

    public function setMigrationsPath(string $path): self
    {
        $this->migrationsPath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }

    public function hasMigrationsByPath(string $path): self
    {
        $this->migrationPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }

    public function loadMigrations(bool $loadMigrations = true): self
    {
        $this->loadMigrations = $loadMigrations;

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasMigration(...$migrationFileNames): self
    {
        return $this->hasMigrationsByName(...$migrationFileNames);
    }

    public function hasMigrations(...$migrationFileNames): self
    {
        return $this->hasMigrationsByName(...$migrationFileNames);
    }

    public function discoversMigrations(bool $discoversMigrations = true, ?string $path = null): self
    {
        $this->discoversMigrations = $discoversMigrations;
        if ($discoversMigrations and ! is_null($path)) {
            return $this->hasMigrationsByPath($path);
        }

        return $this;
    }

    public function runsMigrations(bool $runsMigrations = true): self
    {
        return $this->loadMigrations($runsMigrations);
    }
}
