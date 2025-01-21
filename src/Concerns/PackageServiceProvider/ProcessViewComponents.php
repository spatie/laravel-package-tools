<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessViewComponents
{
    protected function bootViewComponents()
    {
        if (empty($this->package->viewComponents)) {
            return;
        }

        foreach ($this->package->viewComponents as $componentClass => $prefix) {
            $this->loadViewComponentsAs($prefix, [$componentClass]);
        }

        if ($this->app->runningInConsole()) {
            $vendorComponents = $this->package->basePath('/Components');
            $appComponents = base_path("app/View/Components/vendor/{$this->package->shortName()}");

            $this->publishes([$vendorComponents => $appComponents], "{$this->package->name}-components");
        }
    }
}
