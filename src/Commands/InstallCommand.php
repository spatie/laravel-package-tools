<?php

namespace Spatie\LaravelPackageTools\Commands;

use Illuminate\Console\Command;
use Spatie\LaravelPackageTools\Package;

class InstallCommand extends Command
{
    protected Package $package;

    protected bool $shouldPublishConfigFile = false;

    protected bool $shouldPublishMigrations = false;

    protected ?string $copyServiceProviderInApp = null;

    protected ?string $starRepo = null;

    public function __construct(Package $package)
    {
        $this->signature = $package->shortName() . ':install';

        $this->package = $package;

        parent::__construct();
    }

    public function handle()
    {
        if ($this->shouldPublishConfigFile) {
            $this->info('Publishing config file...');

            $this->callSilently("vendor:publish", [
                '--tag' => "{$this->package->shortName()}-config",
            ]);
        }

        if ($this->shouldPublishMigrations) {
            $this->info('Publishing migration...');

            $this->callSilently("vendor:publish", [
                '--tag' => "{$this->package->shortName()}-migrations",
            ]);
        }

        if ($this->starRepo) {
            if ($this->confirm('Would you like to star our repo on GitHub?')) {
                $repoUrl = "https://github.com/{$this->starRepo}";

                if (PHP_OS_FAMILY == 'Darwin') {
                    exec("open {$repoUrl}");
                }
                if (PHP_OS_FAMILY == 'Windows') {
                    exec("start {$repoUrl}");
                }
                if (PHP_OS_FAMILY == 'Linux') {
                    exec("xdg-open {$repoUrl}");
                }
            }
        }

        $this->info("{$this->package->shortName()} has been installed!");
    }

    public function publishConfigFile(): self
    {
        $this->shouldPublishConfigFile = true;

        return $this;
    }

    public function publishMigrations(): self
    {
        $this->shouldPublishMigrations = true;

        return $this;
    }

    public function copyAndRegisterServiceProviderInApp(string $serviceProviderName): self
    {
        $this->copyServiceProviderInApp = $serviceProviderName;

        return $this;
    }

    public function askToStarRepoOnGitHub($vendorSlashRepoName): self
    {
        $this->starRepo = $vendorSlashRepoName;

        return $this;
    }
}
