<?php

namespace Spatie\LaravelPackageTools\Commands;

use Closure;
use Illuminate\Console\Command;
use Spatie\LaravelPackageTools\Package;

class InstallCommand extends Command
{
    protected Package $package;

    public ?Closure $startWith = null;

    protected bool $shouldPublishConfigFile = false;

    protected bool $shouldPublishMigrations = false;

    protected ?string $copyServiceProviderInApp = null;

    protected ?string $starRepo = null;

    public ?Closure $endWith = null;

    public function __construct(Package $package)
    {
        $this->signature = $package->shortName() . ':install';

        $this->package = $package;

        parent::__construct();
    }

    public function handle()
    {
        if ($this->startWith) {
            ($this->startWith)($this);
        }

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

        if ($this->endWith) {
            ($this->endWith)($this);
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

    public function startWith($callable): self
    {
        $this->startWith = $callable;

        return $this;
    }

    public function endWith($callable): self
    {
        $this->endWith = $callable;

        return $this;
    }
}
