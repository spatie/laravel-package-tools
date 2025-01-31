<?php

namespace Spatie\LaravelPackageTools;

use Illuminate\Support\Str;

use Spatie\LaravelPackageTools\Concerns\Package\HasAssets;
use Spatie\LaravelPackageTools\Concerns\Package\HasBladeComponents;
use Spatie\LaravelPackageTools\Concerns\Package\HasCommands;
use Spatie\LaravelPackageTools\Concerns\Package\HasConfigs;
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
    use HasBladeComponents;
    use HasCommands;
    use HasConfigs;
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
        $this->verifyDir($path);
        $this->basePath = $path;

        return $this;
    }

    /* Utility methods */

    private function buildDirectory(string $path, ?string $directory): string
    {
        return $this->appendDirectory($this->basePath($path), $directory);
    }

    private function appendDirectory(string $basePath, ?string $directory): string
    {
        if ($directory === null) {
            return $basePath;
        }

        return $basePath . DIRECTORY_SEPARATOR . ltrim($directory, DIRECTORY_SEPARATOR);
    }

    protected function verifyFile(string ...$files): string
    {
        foreach (collect($files)->flatten()->toArray() as $file) {
            if (is_file($file)) {
                return $file;
            }
        }

        throw InvalidPackage::FileDoesNotExist(
            $this->package->name,
            $file
        );
    }

    protected function verifyDir(string $dir): string
    {
        if (is_dir($dir)) {
            return $dir;
        }

        throw InvalidPackage::DirDoesNotExist(
            $this->package->name,
            $dir
        );
    }
}
