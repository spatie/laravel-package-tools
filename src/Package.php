<?php

namespace Spatie\LaravelPackageTools;

use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Concerns\Package\HasAssets;
use Spatie\LaravelPackageTools\Concerns\Package\HasBladeAnonymousComponents;
use Spatie\LaravelPackageTools\Concerns\Package\HasBladeComponents;
use Spatie\LaravelPackageTools\Concerns\Package\HasBladeCustomDirectives;
use Spatie\LaravelPackageTools\Concerns\Package\HasCommands;
use Spatie\LaravelPackageTools\Concerns\Package\HasConfigs;
use Spatie\LaravelPackageTools\Concerns\Package\HasEvents;
use Spatie\LaravelPackageTools\Concerns\Package\HasInertia;
use Spatie\LaravelPackageTools\Concerns\Package\HasInstallCommand;
use Spatie\LaravelPackageTools\Concerns\Package\HasLivewire;
use Spatie\LaravelPackageTools\Concerns\Package\HasMigrations;
use Spatie\LaravelPackageTools\Concerns\Package\HasRoutes;
use Spatie\LaravelPackageTools\Concerns\Package\HasServiceProviders;
use Spatie\LaravelPackageTools\Concerns\Package\HasTranslations;
use Spatie\LaravelPackageTools\Concerns\Package\HasViewComposers;
use Spatie\LaravelPackageTools\Concerns\Package\HasViews;
use Spatie\LaravelPackageTools\Concerns\Package\HasViewSharedData;
use Spatie\LaravelPackageTools\Concerns\Package\PackageHelpers;

final class Package
{
    use PackageHelpers;

    use HasAssets;
    use HasBladeAnonymousComponents;
    use HasBladeComponents;
    use HasBladeCustomDirectives;
    use HasCommands;
    use HasConfigs;
    use HasEvents;
    use HasInertia;
    use HasLivewire;
    use HasMigrations;
    use HasRoutes;
    use HasServiceProviders;
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
}
