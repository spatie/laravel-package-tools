<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessViews
{
    protected function bootPackageViews(): self
    {
        return $this
            ->bootLoadViews()
            ->bootPublishViews();
    }

    protected function bootLoadViews(): self
    {
        if (! $this->package->viewsLoadsPaths) {
            return $this;
        }

        foreach ($this->package->viewsLoadsPaths as $namespace => $path) {
            $this->loadViewsFrom($this->package->basePath($path), $namespace);
        }

        return $this;
    }

    protected function bootPublishViews(): self
    {
        if (! $this->package->viewsPublishesPaths || ! $this->app->runningInConsole()) {
            return $this;
        }

        foreach ($this->package->viewsPublishesPaths as $namespace => $path) {
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
