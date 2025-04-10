<?php

namespace Spatie\LaravelPackageTools\Commands;

use Illuminate\Console\Command;
use Spatie\LaravelPackageTools\Commands\Concerns\InstallerAskToRunMigrations;
use Spatie\LaravelPackageTools\Commands\Concerns\InstallerAskToStarRepoOnGitHub;
use Spatie\LaravelPackageTools\Commands\Concerns\InstallerPublishResources;
use Spatie\LaravelPackageTools\Commands\Concerns\InstallerServiceProviderInApp;
use Spatie\LaravelPackageTools\Commands\Concerns\InstallerStartWithEndWith;
use Spatie\LaravelPackageTools\Package;

class InstallCommand extends Command
{
    use InstallerAskToRunMigrations;
    use InstallerAskToStarRepoOnGitHub;
    use InstallerPublishResources;
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
