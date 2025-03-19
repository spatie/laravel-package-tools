<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasMigrations
{
    protected static string $migrationsDefaultPath = '../database/migrations';

    public array $migrationNames = [];
    protected ?string $migrationsByNamePath = '../database/migrations';
    public array $migrationPaths = [];
    public bool $loadsMigrations = false;
    public bool $discoversMigrations = false;

    public function hasMigrationsByName(...$migrationNames): self
    {
        $this->migrationNames = array_unique(array_merge(
            $this->migrationNames,
            collect($migrationNames)->flatten()->toArray()
        ));

        $this->migrationsByNamePath = $this->verifyRelativeDirOrNull($this->migrationsByNamePath);

        return $this;
    }

    public function migrationsByNamePath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->migrationsByNamePath, $directory);
    }

    public function setMigrationsPath(string $path): self
    {
        $this->migrationsByNamePath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }

    public function hasMigrationsByPath(string $path): self
    {
        $this->migrationPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }

    public function loadsMigrations(bool $loadsMigrations = true): self
    {
        $this->loadsMigrations = $loadsMigrations;

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasMigration(...$migrationNames): self
    {
        return $this->hasMigrationsByName(...$migrationNames);
    }

    public function hasMigrations(...$migrationNames): self
    {
        return $this->hasMigrationsByName(...$migrationNames);
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
        return $this->loadsMigrations($runsMigrations);
    }
}
