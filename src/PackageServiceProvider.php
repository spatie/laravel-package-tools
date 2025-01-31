<?php

namespace Spatie\LaravelPackageTools;

use ReflectionClass;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessAssets;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessBladeComponents;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessCommands;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessConfigs;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessInertia;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessLivewire;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessMigrations;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessProviders;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessRoutes;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessTranslations;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViews;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViewComposers;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViewSharedData;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

abstract class PackageServiceProvider extends ServiceProvider
{
    use ProcessAssets;
    use ProcessBladeComponents;
    use ProcessCommands;
    use ProcessConfigs;
    use ProcessInertia;
    use ProcessLivewire;
    use ProcessMigrations;
    use ProcessProviders;
    use ProcessRoutes;
    use ProcessTranslations;
    use ProcessViews;
    use ProcessViewComposers;
    use ProcessViewSharedData;


    protected Package $package;

    abstract public function configurePackage(Package $package): void;

    /** @throws InvalidPackage */
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
            ->bootPackageBladeComponents()
            ->bootPackageBladeComponentNamespaces()
            ->bootPackageBladeComponentPaths()
            ->bootPackageCommands()
            ->bootPackageConsoleCommands()
            ->bootPackageConfigs()
            ->bootPackageInertia()
            ->bootPackageLivewire()
            ->bootPackageMigrations()
            ->bootPackageProviders()
            ->bootPackageRoutes()
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

    /* Utility methods */

    private function phpOrStub(string $filename): string
    {
        if (is_file($file = $filename . '.php')) {
            return $file;
        }

        if (is_file($file = $filename . '.php.stub')) {
            return $file;
        }

        return "";
    }

    protected function existingFile(string $file): string
    {
        if (is_file($file)) {
            return $file;
        }

        return "";
    }

    protected static function convertDiscovers(string $path): array
    {
        return collect(File::allfiles($path))->map(function (SplFileInfo $file) use ($path): string {
            return Str::replaceEnd('.php', '', Str::replaceEnd('.php.stub', '', Str::after($file->getPathname(), $path)));
        })->toArray();
    }
}
