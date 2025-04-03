<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessInertia
{
    protected function bootPackageInertia(): self
    {
        if (! $this->package->inertiaComponentsPublishesPaths || ! $this->app->runningInConsole()) {
            return $this;
        }

        /* Publish under two tags for legacy reasons */
        $shortName = $this->package->shortName();
        $tag = "{$shortName}-inertia-components";
        foreach ($this->package->inertiaComponentsPublishesPaths as $namespace => $path) {
            $toPath = resource_path("js/Pages/{$this->package->studlyCase($namespace)}");
            $this->publishes(
                [$this->package->basePath($path) => $toPath],
                $tag
            );
            if ($namespace !== $shortName) {
                $this->publishes(
                    [$this->package->basePath($path) => $toPath],
                    "{$namespace}-inertia-components"
                );
            }
        }

        return $this;
    }
}
