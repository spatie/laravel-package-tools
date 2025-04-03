<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasMigrations
{
    protected static string $migrationsDefaultPath = '../database/migrations';

    public array $migrationLoadsNames = [];
    public array $migrationPublishesNames = [];
    public array $migrationLoadsPaths = [];
    public array $migrationPublishesPaths = [];
    public array $migrationDiscoversPaths = [];
    public bool  $migrationLegacyLoadsPublished = false;
    private ?string $migrationsByNamePath = '../database/migrations';

    public function loadsMigrationsByName(...$migrationNames): self
    {
        return $this->handlesMigrationsByName(__FUNCTION__, $this->migrationLoadsNames, ...$migrationNames);
    }

    public function publishesMigrationsByName(...$migrationNames): self
    {
        return $this->handlesMigrationsByName(__FUNCTION__, $this->migrationPublishesNames, ...$migrationNames);
    }

    private function handlesMigrationsByName(string $method, array &$names, ...$migrationNames): self
    {
        $names = array_unique(array_merge(
            $names,
            collect($migrationNames)->flatten()->toArray()
        ));

        $this->migrationsByNamePath = $this->verifyRelativeDirOrNull($this->migrationsByNamePath);

        return $this;
    }

    public function migrationsByNamePath(?string $directory = null): string
    {
        return $this->verifyPathSet('loads/publishesMigrationsByName', $this->migrationsByNamePath, $directory);
    }

    public function setMigrationsByNamePath(string $path): self
    {
        $this->migrationsByNamePath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }

    public function loadsMigrationsByPath(?string $path = null): self
    {
        $this->migrationLoadsPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$migrationsDefaultPath);

        return $this;
    }

    public function publishesMigrationsByPath(?string $path = null): self
    {
        $this->migrationPublishesPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$migrationsDefaultPath);

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasMigration(string $migrationFileName): self
    {
        return $this->hasMigrations($migrationFileName);
    }

    public function hasMigrations(...$migrationFileNames): self
    {
        return $this->publishesMigrationsByName(...$migrationFileNames);
    }

    public function discoversMigrations(bool $discoversMigrations = true, string $path = '/database/migrations'): self
    {
        // Legacy discoversMigrations uses absolute paths so makes them relative
        $path = '../' . trim($path, '/');

        if ($discoversMigrations) {
            $this->migrationDiscoversPaths[] = $path;
        } elseif (($keyToDelete = array_search($path, $this->migrationDiscoversPaths)) !== false) {
            // Remove path from migrationsByPath list
            unset($this->migrationDiscoversPaths[$keyToDelete]);
        }

        return $this;
    }

    public function runsMigrations(bool $runsMigrations = true): self
    {
        $this->migrationLegacyLoadsPublished = $runsMigrations;

        return $this;
    }
}
