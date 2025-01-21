<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait ProcessAssets
{
    protected function bootAssets(): void
    {
        if (! $this->package->hasAssets || ! $this->app->runningInConsole()) {
            return;
        }

        $vendorAssets = $this->package->basePath('/../resources/dist');
        $appAssets = public_path("vendor/{$this->package->shortName()}");

        $this->publishes([$vendorAssets => $appAssets], "{$this->package->shortName()}-assets");
    }
}
