<?php

namespace Spatie\LaravelPackageTools\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\AskToRunMigrations;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\AskToStarRepoOnGitHub;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\Publishes;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\ServiceProviderInApp;
use Spatie\LaravelPackageTools\Concerns\InstallCommand\StartWithEndWith;
use Spatie\LaravelPackageTools\Package;

class InstallCommand extends Command
{
    use AskToRunMigrations;
    use AskToStarRepoOnGitHub;
    use Publishes;
    use ServiceProviderInApp;
    use StartWithEndWith;

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
