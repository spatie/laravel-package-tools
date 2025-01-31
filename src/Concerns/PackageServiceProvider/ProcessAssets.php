<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessAssets
{
    protected function bootPackageAssets(): self
    {
        if (! $this->package->hasAssets || ! $this->app->runningInConsole()) {
            return $this;
        }

        $this->publishes(
            [$this->package->assetsPath() => public_path("vendor/{$this->package->shortName()}")],
            "{$this->package->shortName()}-assets"
        );

        return $this;
    }
}
