<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessInertia
{
    protected function bootPackageInertia(): self
    {
        if (! $this->package->inertiaComponentsPaths || ! $this->app->runningInConsole()) {
            return $this;
        }

        /* Publish under two tags for legacy reasons */
        $shortName = $this->package->shortName();
        $tag = "{$shortName}-inertia-components";
        foreach ($this->package->inertiaComponentsPaths as $namespace => $path) {
            $this->publishes(
                [$this->package->basePath($path) => resource_path("js/Pages/{$this->package->studlyCase($namespace)}")],
                $tag
            );
            if ($namespace !== $shortName) {
                $this->publishes(
                    [$this->package->basePath($path) => resource_path("js/Pages/{$this->package->studlyCase($namespace)}")],
                    "{$namespace}-inertia-components"
                );
            }
        }

        return $this;
    }
}
