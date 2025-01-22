<?php

namespace Spatie\LaravelPackageTools\Concerns\InstallCommand;

trait askToRunMigrations
{
    protected bool $askToRunMigrations = false;

    public function askToRunMigrations(): self
    {
        $this->askToRunMigrations = true;

        return $this;
    }

    protected function processAskToRunMigrations(): void
    {
        if ($this->askToRunMigrations) {
            if ($this->confirm('Would you like to run the migrations now?')) {
                $this->comment('Running migrations...');

                $this->call('migrate');
            }
        }
    }
}
