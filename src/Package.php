<?php

namespace Spatie\LaravelPackageTools;

use Illuminate\Support\Str;

class Package
{
    public string $name;

    public ?string $configFileName = null;

    public bool $hasViews = false;

    public bool $hasTranslations = false;

    public bool $hasAssets = false;

    public array $migrationFileNames = [];

    public array $routeFileNames = [];

    public array $commands = [];

    public array $viewComponents = [];

    public array $sharedViewData = [];

    public array $viewComposers = [];

    public array $middlewares = [];

    public string $basePath;

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function hasConfigFile(string $configFileName = null): self
    {
        $this->configFileName = $configFileName ?? $this->shortName();

        return $this;
    }

    public function shortName(): string
    {
        return Str::after($this->name, 'laravel-');
    }

    public function hasViews(): self
    {
        $this->hasViews = true;

        return $this;
    }

    public function hasViewComponent(string $prefix, string $viewComponentName): self
    {
        $this->viewComponents[$viewComponentName] = $prefix;

        return $this;
    }

    public function hasViewComponents(string $prefix,  ...$viewComponentNames): self
    {
        foreach ($viewComponentNames as $componentName) {
            $this->viewComponents[$componentName] = $prefix;
        }

        return $this;
    }

    public function sharesDataWithAllViews(string $name, $value): self
    {
        $this->sharedViewData[$name] = $value;

        return $this;
    }

    public function hasViewComposer($view, $viewComposer): self
    {
        if (! is_array($view)) {
            $view = [$view];
        }

        foreach ($view as $viewName) {
            $this->viewComposers[$viewName] = $viewComposer;
        }

        return $this;
    }

    public function hasTranslations(): self
    {
        $this->hasTranslations = true;

        return $this;
    }

    public function hasAssets(): self
    {
        $this->hasAssets = true;

        return $this;
    }

    public function hasMigration(string $migrationFileName): self
    {
        $this->migrationFileNames[] = $migrationFileName;

        return $this;
    }

    public function hasMigrations(...$migrationFileNames): self
    {
        $this->migrationFileNames = array_merge(
            $this->migrationFileNames,
            collect($migrationFileNames)->flatten()->toArray()
        );

        return $this;
    }

    public function hasCommand(string $commandClassName): self
    {
        $this->commands[] = $commandClassName;

        return $this;
    }

    public function hasCommands(...$commandClassNames): self
    {
        $this->commands = array_merge($this->commands, collect($commandClassNames)->flatten()->toArray());

        return $this;
    }

    public function hasRoute(string $routeFileName): self
    {
        $this->routeFileNames[] = $routeFileName;

        return $this;
    }

    public function hasRoutes(...$routeFileNames): self
    {
        $this->routeFileNames = array_merge($this->routeFileNames, collect($routeFileNames)->flatten()->toArray());

        return $this;
    }

    public function hasMiddlewares(array $middlewares): self
    {
        $this->middlewares = array_merge($this->middlewares, $middlewares);

        return $this;
    }

    public function basePath(string $directory = null): string
    {
        if ($directory === null) {
            return $this->basePath;
        }

        return $this->basePath . DIRECTORY_SEPARATOR . ltrim($directory, DIRECTORY_SEPARATOR);
    }

    public function setBasePath(string $path): self
    {
        $this->basePath = $path;

        return $this;
    }
}
