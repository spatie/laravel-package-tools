<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessAssets
{
    protected function bootPackageAssets(): self
    {
        if (! $this->package->assetsPaths || ! $this->app->runningInConsole()) {
            return $this;
        }

        $tag = "{$this->package->shortName()}-assets";
        foreach ($this->package->assetsPaths as $namespace => $path) {
            $this->publishes(
                [$this->package->basePath($path) => public_path("vendor/{$namespace}")],
                $tag
            );
        }

        return $this;
    }
}
