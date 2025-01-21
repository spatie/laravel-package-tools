<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait ProcessProviders
{
    protected function bootProviders()
    {
        if (! $this->package->publishableProviderName || ! $this->app->runningInConsole()) {
            return;
        }

        $providerName = $this->package->publishableProviderName;
        $vendorProvider = $this->package->basePath("/../resources/stubs/{$providerName}.php.stub");
        $appProvider = base_path("app/Providers/{$providerName}.php");

        $this->publishes([$vendorProvider => $appProvider], "{$this->package->shortName()}-provider");
    }
}
