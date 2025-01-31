<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessProviders
{
    protected function bootPackageProviders(): self
    {
        if (empty($this->package->publishableProviderNames) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $vendorPath = $this->package->publishableProviderPath();
        $appPath = app_path("Providers");
        $tag = "{$this->package->shortName()}-provider";
        foreach ($this->package->publishableProviderNames as $providerName) {
            $this->publishes(
                ["{$vendorPath}/{$providerName}.php.stub" => "{$appPath}/{$providerName}.php"],
                $tag
            );
        }

        return $this;
    }
}
