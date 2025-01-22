<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessPackageAssets
{
    protected function bootPackageAssets(): self
    {
        if (! $this->package->hasAssets || ! $this->app->runningInConsole()) {
            return $this;
        }

        $vendorAssets = $this->package->basePath('/../resources/dist');
        $appAssets = public_path("vendor/{$this->package->shortName()}");

        $this->publishes(
            [$vendorAssets => $appAssets],
            "{$this->package->shortName()}-assets"
        );

        return $this;
    }
}
