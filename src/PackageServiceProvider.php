<?php

namespace Spatie\LaravelPackageTools;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessAssets;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessBlade;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessCommands;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessConfigs;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessEvents;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessInertia;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessLivewire;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessMigrations;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessProviders;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessRoutes;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessTranslations;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViewComposers;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViews;
use Spatie\LaravelPackageTools\Concerns\PackageServiceProvider\ProcessViewSharedData;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

abstract class PackageServiceProvider extends ServiceProvider
{
    use ProcessAssets;
    use ProcessBlade;
    use ProcessCommands;
    use ProcessConfigs;
    use ProcessEvents;
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
            ->bootPackageBlade()
            ->bootPackageCommands()
            ->bootPackageConfigs()
            ->bootPackageEvents()
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

    // Get namespace for directory from the first class file in the directory
    protected static function getNamespaceOfDirectory($path): string
    {
        foreach (glob($path . '/*.php') as $file) {
            if ($namespace = self::getNamespaceFromFile($file)) {
                return $namespace;
            }
        }

        throw InvalidPackage::cannotDetermineNamespace(
            $this->package->name,
            'hasBladeComponentsByPath',
            $path
        );
    }

    protected static function getNamespaceFromFile($file): string
    {
        $tokens = PhpToken::tokenize(file_get_contents($file));
        $namespace = [];
        foreach ($tokens as $index => $token) {
            if ($token->is(T_NAMESPACE) && $tokens[$index + 2]->is(T_STRING)) {
                for ($i = $index + 2 ;! $tokens[$i]->is(T_WHITESPACE);$i++) {
                    if ($tokens[$i]->text === ";") {
                        continue;
                    }
                    $namespace[] = $tokens[$i]->text;
                }

                return implode('', $namespace)."\\";
            }
        }

        return "";
    }

    protected static function getClassesInPaths(string $method, ...$paths): array
    {
        $classes = [];
        foreach (collect($paths)->flatten()->toArray() as $path) {
            $namespace = self::getNamespaceOfDirectory($path);
            $pathClasses = [];

            foreach (File::allfiles($this->package->buildDirectory($path)) as $file) {
                if (! str_ends_with($filename = $file->getPathname(), '.php')) {
                    continue;
                }

                $commandClasses[] = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($filename, $path)
                );
            }

            if (empty($pathClasses)) {
                throw InvalidPackage::pathDoesNotContainClasses(
                    $this->name,
                    $method,
                    $path
                );
            }

            $classes = array_merge($classes, $pathClasses);
        }

        $this->package->verifyClassNames($method, $commandClasses);

        return $classes;
    }
}
