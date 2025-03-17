<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessLivewire
{
    protected function bootPackageLivewire(): self
    {
        if (! $this->package->livewireComponentPaths || ! $this->app->runningInConsole()) {
            return $this;
        }

        $tag = "{$this->package->shortName()}-livewire-components";
        foreach ($this->package->livewireComponentPaths as $namespace => $componentsPath) {
            $this->publishes(
                [$this->basePath($componentsPath) => app_path("Livewire/{$namespace}")],
                $tag
            );
        }

        return $this;
    }
}
