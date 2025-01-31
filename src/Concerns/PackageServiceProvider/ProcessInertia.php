<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessInertia
{
    protected function bootPackageInertia(): self
    {
        if (! $this->package->hasInertiaComponents || ! $this->app->runningInConsole()) {
            return $this;
        }

        $namespace = $this->package->inertiaNamespace();
        $directoryName = Str::of($namespace)->studly()->remove('-')->value();
        $this->publishes(
            [$this->package->inertiaComponentsPath() => resource_path("js/Pages/{$directoryName}")],
            "{$namespace}-inertia-components"
        );

        return $this;
    }
}
