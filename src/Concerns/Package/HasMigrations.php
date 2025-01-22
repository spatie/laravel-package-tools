<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasMigrations
{
    public bool $runsMigrations = false;

    public bool $discoversMigrations = false;

    public ?string $migrationsPath = null;

    public array $migrationFileNames = [];

    public function runsMigrations(bool $runsMigrations = true): self
    {
        $this->runsMigrations = $runsMigrations;

        return $this;
    }

    public function hasMigration(string $migrationFileName): self
    {
        $this->migrationFileNames[] = $migrationFileName;

        return $this;
    }

    public function hasMigrations(...$migrationFileNames): self
    {
        $this->migrationFileNames = array_merge(
            $this->migrationFileNames,
            collect($migrationFileNames)->flatten()->toArray()
        );

        return $this;
    }

    public function discoversMigrations(bool $discoversMigrations = true, string $path = '/database/migrations'): self
    {
        $this->discoversMigrations = $discoversMigrations;
        $this->migrationsPath = $path;

        return $this;
    }
}
