<?php

namespace Spatie\LaravelPackageTools;

use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Traits\HasAssets;
use Spatie\LaravelPackageTools\Traits\HasCommands;
use Spatie\LaravelPackageTools\Traits\HasConfigs;
use Spatie\LaravelPackageTools\Traits\HasConsoleCommands;
use Spatie\LaravelPackageTools\Traits\HasInertia;
use Spatie\LaravelPackageTools\Traits\HasInstallCommand;
use Spatie\LaravelPackageTools\Traits\HasMigrations;
use Spatie\LaravelPackageTools\Traits\HasProviders;
use Spatie\LaravelPackageTools\Traits\HasRoutes;
use Spatie\LaravelPackageTools\Traits\HasTranslations;
use Spatie\LaravelPackageTools\Traits\HasViewComponents;
use Spatie\LaravelPackageTools\Traits\HasViewComposers;
use Spatie\LaravelPackageTools\Traits\HasViews;
use Spatie\LaravelPackageTools\Traits\HasViewSharedData;

class Package
{
    use HasAssets;
    use HasCommands;
    use HasConsoleCommands;
    use HasConfigs;
    use HasInertia;
    use HasInstallCommand;
    use HasMigrations;
    use HasProviders;
    use HasRoutes;
    use HasTranslations;
    use HasViews;
    use HasViewComponents;
    use HasViewComposers;
    use HasViewSharedData;

    public string $name;

    public string $basePath;

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function shortName(): string
    {
        return Str::after($this->name, 'laravel-');
    }

    public function basePath(string $directory = null): string
    {
        if ($directory === null) {
            return $this->basePath;
        }

        return $this->basePath . DIRECTORY_SEPARATOR . ltrim($directory, DIRECTORY_SEPARATOR);
    }

    public function setBasePath(string $path): static
    {
        $this->basePath = $path;

        return $this;
    }
}
