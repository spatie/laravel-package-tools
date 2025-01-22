<?php

namespace Spatie\LaravelPackageTools\Commands;

use Closure;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\InstallCommandAskToRunMigrations;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\InstallCommandAskToStarRepoOnGitHub;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\InstallCommandPublishes;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\InstallCommandServiceProviderInApp;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\InstallCommandStartWithEndWith;

class InstallCommand extends Command
{
    use InstallCommandAskToRunMigrations;
    use InstallCommandAskToStarRepoOnGitHub;
    use InstallCommandPublishes;
    use InstallCommandServiceProviderInApp;
    use InstallCommandStartWithEndWith;

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
