<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessLivewire
{
    protected function bootPackageLivewire(): self
    {
        if (! $this->package->hasLivewire) {
            return $this;
        }

        if (! $this->app->runningInConsole()) {
            return $this;
        }

        $livewireViewsDir = $this->package->livewireViewsPath();
        $packageDirectoryName = Str::of($this->package->livewireNamespace())->studly()->remove('-')->value();

        $this->publishes(
            [$livewireViewsDir => resource_path("views/livewire/{$packageDirectoryName}")],
            "{$this->package->livewireNamespace()}-livewire-components"
        );

        $livewireComponentsDir = $this->package->livewireComponentsPath();

        /* Volt components have only a views file */
        if (! is_dir($livewireComponentsDir)) {
            return $this;
        }

        $this->publishes(
            [$livewireComponentsDir => app_path("Livewire/{$packageDirectoryName}")],
            "{$this->package->livewireNamespace()}-livewire-components"
        );

        return $this;
    }
}
