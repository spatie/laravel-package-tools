<?php

namespace Spatie\LaravelPackageTools;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;

use Spatie\LaravelPackageTools\Concerns\Package\ProcessAssets;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessCommands;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessConfigs;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessConsoleCommands;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessInertia;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessMigrations;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessProviders;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessRoutes;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessTranslations;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessViewComponents;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessViewComposers;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessViews;
use Spatie\LaravelPackageTools\Concerns\Package\ProcessViewSharedData;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

abstract class PackageServiceProvider extends ServiceProvider
{
    use ProcessAssets;
    use ProcessCommands;
    use ProcessConsoleCommands;
    use ProcessConfigs;
    use ProcessInertia;
    use ProcessMigrations;
    use ProcessProviders;
    use ProcessRoutes;
    use ProcessTranslations;
    use ProcessViews;
    use ProcessViewComponents;
    use ProcessViewComposers;
    use ProcessViewSharedData;

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

        $this->registerConfigs();

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

        $this->bootAssets();
        $this->bootCommands();
        $this->bootConsoleCommands();
        $this->bootConfigs();
        $this->bootInertia();
        $this->bootMigrations();
        $this->bootProviders();
        $this->bootRoutes();
        $this->bootTranslations();
        $this->bootViews();
        $this->bootViewComponents();
        $this->bootViewComposers();
        $this->bootViewSharedData();

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
