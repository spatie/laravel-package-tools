<?php

namespace Spatie\LaravelPackageTools;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;

use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageAssets;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageCommands;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageConfigs;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageConsoleCommands;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageInertia;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageMigrations;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageProviders;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageRoutes;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageTranslations;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageViewComponents;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageViewComposers;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageViews;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessPackageViewSharedData;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

abstract class PackageServiceProvider extends ServiceProvider
{
    use ProcessPackageAssets;
    use ProcessPackageCommands;
    use ProcessPackageConsoleCommands;
    use ProcessPackageConfigs;
    use ProcessPackageInertia;
    use ProcessPackageMigrations;
    use ProcessPackageProviders;
    use ProcessPackageRoutes;
    use ProcessPackageTranslations;
    use ProcessPackageViews;
    use ProcessPackageViewComponents;
    use ProcessPackageViewComposers;
    use ProcessPackageViewSharedData;

    protected Package $package;

    abstract public function configurePackage(Package $package): void;

    /** @throws InvalidPackage */
    public function register()
    {
        $this->registeringPackage();

        $this->package = $this->newPackage();
        $this->package->setBasePath($this->getPackageBaseDir());

        $this->configurePackage($this->package);
        if (empty($this->package->name)) {
            throw InvalidPackage::nameIsRequired();
        }

        $this->registerPackageConfigs();

        $this->packageRegistered();

        return $this;
    }

    public function newPackage(): Package
    {
        return new Package();
    }

    protected function getPackageBaseDir(): string
    {
        $reflector = new ReflectionClass(get_class($this));

        return dirname($reflector->getFileName());
    }

    public function boot()
    {
        $this->bootingPackage();

        $this
            ->bootPackageAssets()
            ->bootPackageCommands()
            ->bootPackageConsoleCommands()
            ->bootPackageConfigs()
            ->bootPackageInertia()
            ->bootPackageMigrations()
            ->bootPackageProviders()
            ->bootPackageRoutes()
            ->bootPackageTranslations()
            ->bootPackageViews()
            ->bootPackageViewComponents()
            ->bootPackageViewComposers()
            ->bootPackageViewSharedData();

        $this->packageBooted();

        return $this;
    }

    public function packageView(?string $namespace): ?string
    {
        return is_null($namespace)
            ? $this->package->shortName()
            : $this->package->viewNamespace;
    }

    /* Lifecycle hooks */

    public function creatingPackage(): void
    {
    }

    public function registeringPackage(): void
    {
    }

    public function packageRegistered(): void
    {
    }

    public function bootingPackage(): void
    {
    }

    public function packageBooted(): void
    {
    }
}
