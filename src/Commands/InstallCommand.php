<?php

namespace Spatie\LaravelPackageTools\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\InstallerAskToRunMigrations;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\InstallerAskToStarRepoOnGitHub;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\InstallerPublishes;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\InstallerServiceProviderInApp;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\InstallerStartWithEndWith;
use Spatie\LaravelPackageTools\Package;

class InstallCommand extends Command
{
    use InstallerAskToRunMigrations;
    use InstallerAskToStarRepoOnGitHub;
    use InstallerPublishes;
    use InstallerServiceProviderInApp;
    use InstallerStartWithEndWith;

    protected Package $package;

    public $hidden = true;

    public function __construct(Package $package, ?string $command = 'install', ?string $description = null)
    {
        $this->signature = $package->shortName() . ':' . $command;

        $this->description ??= Str::title($command) . ' ' . $package->name;

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
