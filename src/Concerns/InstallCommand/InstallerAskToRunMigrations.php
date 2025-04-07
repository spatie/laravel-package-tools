<?php

namespace Spatie\LaravelPackageTools\Concerns\InstallCommand;

trait InstallerAskToRunMigrations
{
    protected bool $askToRunMigrations = false;

    public function askToRunMigrations(): self
    {
        $this->askToRunMigrations = true;

        return $this;
    }

    protected function processAskToRunMigrations(): self
    {
        if ($this->askToRunMigrations) {
            if ($this->package->migrationLoadsNames || $this->package->migrationLoadsPaths ||
                (
                    $this->package->migrationLegacyLoadsPublished &&
                    ($this->package->migrationPublishesNames || $this->package->migrationPublishesPaths)
                )
            ) {
                $this->comment('This package has migrations that need to be run.');
                $this->comment('Note: Any other pending migrations will be run at the same time.');
            }

            if ($this->confirm('Would you like to run migrations now?')) {
                $this->comment('Running migrations...');

                $this->call('migrate');
            }
        }

        return $this;
    }
}
