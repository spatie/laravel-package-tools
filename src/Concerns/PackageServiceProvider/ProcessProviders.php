<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessProviders
{
    protected function bootPackageProviders(): self
    {
        if (empty($this->package->publishableProviderNames) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $appPath = app_path("Providers");
        $tag = "{$this->package->shortName()}-provider";
        foreach ($this->package->publishableProviderNames as $providerName) {
            $targetFile = basename($providerName, '.php.stub') . '.php';
            $this->publishes(
                [$providerName => "{$appPath}/{$targetFile}"],
                $tag
            );
        }

        return $this;
    }
}
