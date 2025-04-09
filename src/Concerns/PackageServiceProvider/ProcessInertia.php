<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessInertia
{
    protected function bootPackageInertia(): self
    {
        if (! $this->package->hasInertiaComponents) {
            return $this;
        }

        $namespace = $this->package->viewNamespace;
        $directoryName = Str::of($this->packageView($namespace))->studly()->remove('-')->value();
        $vendorComponents = $this->package->basePath('/../resources/js/Pages');
        $appComponents = base_path("resources/js/Pages/{$directoryName}");

        if ($this->app->runningInConsole()) {
            $this->publishes(
                [$vendorComponents => $appComponents],
                "{$this->packageView($namespace)}-inertia-components"
            );
        }

        return $this;
    }
}
