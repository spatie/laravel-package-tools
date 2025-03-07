<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessInertia
{
    protected function bootPackageInertia(): self
    {
        if (! $this->package->inertiaComponentsPaths || ! $this->app->runningInConsole()) {
            return $this;
        }

        $tag = "{$this->package->shortName()}-inertia-components";
        foreach ($this->package->inertiaComponentsPaths as $namespace => $path) {
            $this->publishes(
                [$this->package->basePath($path) => resource_path("js/Pages/{$namespace}")],
                $tag
            );
        }

        return $this;
    }
}
