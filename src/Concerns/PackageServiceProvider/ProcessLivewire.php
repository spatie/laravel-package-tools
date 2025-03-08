<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessLivewire
{
    protected function bootPackageLivewire(): self
    {
        if (! $this->package->livewirePaths || ! $this->app->runningInConsole()) {
            return $this;
        }

        $tag = "{$this->package->shortName()}-livewire-components";
        foreach ($this->package->livewirePaths as $namespace => [$viewsPath, $componentsPath]) {
            $this->publishes(
                [$this->basePath($viewsPath) => resource_path("views/livewire/{$this->package->studlyCase($namespace)}")],
                $tag
            );

            /* Volt components have only a views file */
            if (! is_dir($livewireComponentsDir)) {
                return $this;
            }

            $this->publishes(
                [$this->basePath($componentsPath) => app_path("Livewire/{$this->package->studlyCase($namespace)}")],
                $tag
            );
        }

        return $this;
    }
}
