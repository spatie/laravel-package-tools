<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessViews
{
    protected function bootPackageViews(): self
    {
        if (! $this->package->hasViews) {
            return $this;
        }

        $namespace = $this->package->viewNamespace();
        $vendorViews = $this->package->viewsPath();

        $this->loadViewsFrom($vendorViews, $namespace);

        if (! $this->app->runningInConsole()) {
            return $this;
        }

        $this->publishes(
            [$vendorViews => resource_path("views/vendor/{$namespace}")],
            "{$namespace}-views"
        );

        return $this;
    }
}
