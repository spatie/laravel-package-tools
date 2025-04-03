<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessServiceProviders
{
    protected function bootPackageServiceProviders(): self
    {
        if (! $this->app->runningInConsole()) {
            return $this;
        }

        return $this
            ->bootPublishServiceProvidersByName()
            ->bootPublishServiceProvidersByPath();
    }

    protected function bootPublishServiceProvidersByName(): self
    {
        if (empty($this->package->publishableProviderNames)) {
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

    protected function bootPublishServiceProvidersByPath(): self
    {
        if (empty($this->package->publishableProviderPaths)) {
            return $this;
        }

        $appPath = app_path("Providers");
        $tag = "{$this->package->shortName()}-provider";
        foreach ($this->package->publishableProviderPaths as $path) {
            foreach (glob($this->package->basePath($path) . '/*.php.stub') as $file) {
                $this->publishes(
                    [$file => $appPath . "/" . basename($file, '.stub')],
                    $tag
                );
            }
        }

        return $this;
    }
}
