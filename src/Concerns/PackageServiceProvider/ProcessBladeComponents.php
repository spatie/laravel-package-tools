<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessBladeComponents
{
    protected function bootPackageBladeComponents(): self
    {
        if (empty($this->package->viewComponents)) {
            return $this;
        }

        $componentsByPrefix = [];

        foreach ($this->package->viewComponents as $componentClass => $prefix) {
            $componentsByPrefix[$prefix][] = $componentClass;
        }

        foreach ($componentsByPrefix as $prefix => $components) {
            $this->loadViewComponentsAs($prefix, $components);
        }


        if ($this->app->runningInConsole()) {
            $vendorComponents = $this->package->basePath(DIRECTORY_SEPARATOR . 'Components');
            $appComponents = base_path("app/View/Components/vendor/{$this->package->shortName()}");

            $this->publishes([$vendorComponents => $appComponents], "{$this->package->name}-components");
        }

        return $this;
    }
}
