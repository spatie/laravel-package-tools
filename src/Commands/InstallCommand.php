<?php

namespace Spatie\LaravelPackageTools\Commands;

use Closure;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\askToRunMigrations;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\askToStarRepoOnGitHub;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\publishes;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\serviceProviderInApp;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\startWithEndWith;

class InstallCommand extends Command
{
    use askToRunMigrations;
    use askToStarRepoOnGitHub;
    use publishes;
    use serviceProviderInApp;
    use startWithEndWith;

    protected Package $package;

    public $hidden = true;

    public function __construct(Package $package)
    {
        $this->signature = $package->shortName() . ':install';

        $this->description = 'Install ' . $package->name;

        $this->package = $package;

        parent::__construct();
    }

    public function handle()
    {
        $this->processStartWith();

        $this->info("Installing {$this->package->shortName()}...");

        $this->processPublishes();
        $this->processAskToRunMigrations();
        $this->processServiceProviderInApp();
        $this->processStarRepo();

        $this->info("{$this->package->shortName()} has been installed!");

        $this->processEndWith();
    }
}
