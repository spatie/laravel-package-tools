<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessViews
{
    protected function bootPackageViews(): self
    {
        if (! $this->package->viewsPaths) {
            return $this;
        }

        foreach ($this->package->viewsPaths as $namespace => $path) {
            $this->loadViewsFrom($this->package->basePath($path), $namespace);
        }

        if (! $this->app->runningInConsole()) {
            return $this;
        }

        foreach ($this->package->viewsPaths as $namespace => $path) {
            $this->publishes(
                [$this->package->basePath($path) => resource_path("views/vendor/{$namespace}")],
                "{$this->package->shortName()}-views"
            );
            if ($this->package->shortName() !== $namespace) {
                $this->publishes(
                    [$this->package->basePath($path) => resource_path("views/vendor/{$namespace}")],
                    "{$namespace}-views"
                );
            }
        }

        return $this;
    }
}
