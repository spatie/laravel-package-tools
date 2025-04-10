<?php

namespace Spatie\LaravelPackageTools\Commands;

use Illuminate\Console\Command;
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

    public function __construct(Package $package)
    {
        $this->signature = $package->shortName() . ':install';

        $this->description = 'Install ' . $package->name;

        $this->package = $package;

        $this->hidden = true;

        parent::__construct();
    }

    public function handle()
    {
        $this
            ->processStartWith()
            ->processPublishes()
            ->processAskToRunMigrations()
            ->processCopyServiceProviderInApp()
            ->processStarRepo()
            ->processEndWith();

        $this->info("{$this->package->shortName()} has been installed!");
    }
}
