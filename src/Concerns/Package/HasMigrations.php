<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasMigrations
{

    public array $migrationFileNames = [];
    public bool $loadMigrations = false;
    public bool $discoversMigrations = false;
    protected string $migrationsPath = '/../database/migrations';

    public function hasMigrations(...$migrationFileNames): self
    {
        $this->migrationFileNames = array_merge(
            $this->migrationFileNames,
            collect($migrationFileNames)->flatten()->toArray()
        );

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasMigration(...$migrationFileNames): self
    {
        return $this->hasMigrations(...$migrationFileNames);
    }

    public function migrationsPath(?string $directory = null): string
    {
        return $this->buildDirectory($this->migrationsPath, $directory);
    }

    public function setMigrationsPath(string $path): self
    {
        $this->verifyDir($this->buildDirectory($path));
        $this->migrationsPath = $path;

        return $this;
    }

    public function discoversMigrations(bool $discoversMigrations = true, ?string $path = null): self
    {
        $this->discoversMigrations = $discoversMigrations;
        $this->migrationsPath = $path ?? $this->migrationsPath;

        return $this;
    }

    public function loadMigrations(bool $loadMigrations = true): self
    {
        $this->loadMigrations = $loadMigrations;

        return $this;
    }

    /* Legacy backwards compatibility */
    public function runsMigrations(bool $runsMigrations = true): self
    {
        return $this->loadMigrations($runsMigrations);
    }
}
