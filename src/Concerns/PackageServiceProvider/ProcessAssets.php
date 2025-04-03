<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessAssets
{
    protected function bootPackageAssets(): self
    {
        return $this->bootPublishesAssets();
    }

    protected function bootPublishesAssets(): self
    {
        if (! $this->package->assetsPublishesPaths || ! $this->app->runningInConsole()) {
            return $this;
        }

        $tag = "{$this->package->shortName()}-assets";
        foreach ($this->package->assetsPublishesPaths as $namespace => $path) {
            $this->publishes(
                [$this->package->basePath($path) => public_path("vendor/{$namespace}")],
                $tag
            );
        }

        return $this;
    }
}
