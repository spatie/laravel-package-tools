<?php

namespace Spatie\LaravelPackageTools;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\PackageServiceProviderHelpers;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessAssets;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessBladeAnonymousComponents;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessBladeComponents;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessBladeCustomDirectives;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessCommands;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessConfigs;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessEvents;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessInertia;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessLivewire;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessMigrations;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessRoutes;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessServiceProviders;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessTranslations;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViewComposers;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViews;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViewSharedData;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

abstract class PackageServiceProvider extends ServiceProvider
{
    use PackageServiceProviderHelpers;

    use ProcessAssets;
    use ProcessBladeAnonymousComponents;
    use ProcessBladeComponents;
    use ProcessBladeCustomDirectives;
    use ProcessCommands;
    use ProcessConfigs;
    use ProcessEvents;
    use ProcessInertia;
    use ProcessLivewire;
    use ProcessMigrations;
    use ProcessRoutes;
    use ProcessServiceProviders;
    use ProcessTranslations;
    use ProcessViews;
    use ProcessViewComposers;
    use ProcessViewSharedData;


    protected Package $package;
    protected bool $notPublishable;

    abstract public function configurePackage(Package $package): void;

    public function register(): self
    {
        $this->registeringPackage();

        $this->package = $this->newPackage();
        $this->package->setBasePath($this->getPackageBaseDir());

        $this->configurePackage($this->package);

        /* Validate mandatory attributes */
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

    public function boot(): self
    {
        $this->bootingPackage();

        $this
            ->bootPackageAssets()
            ->bootPackageBladeAnonymousComponents()
            ->bootPackageBladeComponents()
            ->bootPackageBladeCustomDirectives()
            ->bootPackageCommands()
            ->bootPackageConfigs()
            ->bootPackageEvents()
            ->bootPackageInertia()
            ->bootPackageLivewire()
            ->bootPackageMigrations()
            ->bootPackageRoutes()
            ->bootPackageServiceProviders()
            ->bootPackageTranslations()
            ->bootPackageViews()
            ->bootPackageViewComposers()
            ->bootPackageViewSharedData();

        $this->packageBooted();

        return $this;
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
