<?php

namespace Spatie\LaravelPackageTools;

use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Concerns\Package\HasAssets;
use Spatie\LaravelPackageTools\Concerns\Package\HasBlade;
use Spatie\LaravelPackageTools\Concerns\Package\HasCommands;
use Spatie\LaravelPackageTools\Concerns\Package\HasConfigs;
use Spatie\LaravelPackageTools\Concerns\Package\HasEvents;
use Spatie\LaravelPackageTools\Concerns\Package\HasInertia;
use Spatie\LaravelPackageTools\Concerns\Package\HasInstallCommand;
use Spatie\LaravelPackageTools\Concerns\Package\HasLivewire;
use Spatie\LaravelPackageTools\Concerns\Package\HasMigrations;
use Spatie\LaravelPackageTools\Concerns\Package\HasProviders;
use Spatie\LaravelPackageTools\Concerns\Package\HasRoutes;
use Spatie\LaravelPackageTools\Concerns\Package\HasTranslations;
use Spatie\LaravelPackageTools\Concerns\Package\HasViewComposers;
use Spatie\LaravelPackageTools\Concerns\Package\HasViews;
use Spatie\LaravelPackageTools\Concerns\Package\HasViewSharedData;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

final class Package
{
    use HasAssets;
    use HasBlade;
    use HasCommands;
    use HasConfigs;
    use HasEvents;
    use HasInertia;
    use HasLivewire;
    use HasMigrations;
    use HasProviders;
    use HasRoutes;
    use HasTranslations;
    use HasViews;
    use HasViewComposers;
    use HasViewSharedData;

    use HasInstallCommand;

    public string $name;
    protected string $basePath;

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function shortName(): string
    {
        return Str::after($this->name, 'laravel-');
    }

    public function basePath(?string $directory = null): string
    {
        return $this->appendDirectory($this->basePath, $directory);
    }

    public function setBasePath(string $path): self
    {
        $this->verifyDir(__FUNCTION__, $path);
        $this->basePath = $path;

        return $this;
    }

    /* Utility methods */

    public function buildDirectory(string $path, ?string $directory = null): string
    {
        return $this->appendDirectory($this->basePath($path), $directory);
    }

    private function appendDirectory(string $basePath, ?string $directory = null): string
    {
        if ($directory === null) {
            return $basePath;
        }

        return $basePath . DIRECTORY_SEPARATOR . ltrim($directory, DIRECTORY_SEPARATOR);
    }

    public function verifyClassNames(string $method, ...$classes): void
    {
        /* Avoid autoloading classes if production */
        if (! env('APP_DEBUG', false)) {
            return;
        }

        $classes = collect($classes)->flatten()->toArray();
        foreach ($classes as $class) {
            if (! class_exists($class)) {
                throw InvalidPackage::classDoesNotExist(
                    $this->name,
                    $method,
                    $class
                );
            }
        }
    }

    private function verifyFiles(string $method, string ...$files): void
    {
        foreach (collect($files)->flatten()->toArray() as $file) {
            if (! is_file($this->buildDirectory($file))) {
                throw InvalidPackage::fileDoesNotExist(
                    $this->name,
                    $method,
                    $file
                );
            }
        }
    }

    private function verifyDir(string $method, string $dir): void
    {
        if (! is_dir($dir)) {
            throw InvalidPackage::dirDoesNotExist(
                $this->name,
                $method,
                $dir
            );
        }
    }

    private function verifyRelativeDir(string $method, string $dir): string
    {
        $this->verifyDir($method, $this->buildDirectory($dir));

        return $dir;
    }

    private function verifyRelativeDirs(string $method, array $dirs): void
    {
        foreach ($dirs as $dir) {
            $this->verifyDir($method, $this->buildDirectory($dir));
        }
    }

    private function verifyDirOrNull(string $dir): string
    {
        return is_dir($this->buildDirectory($dir)) ? $dir : null;
    }

    private function verifyPathSet(string $method, string $path, ?string $subpath = null): string
    {
        if (! $path) {
            throw InvalidPackage::defaultPathDoesNotExist(
                $this->name,
                __FUNCTION__
            );
        }

        return $this->buildDirectory($path, $subpath);
    }
}
