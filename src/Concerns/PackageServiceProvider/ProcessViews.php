<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessViews
{
    protected function bootPackageViews(): self
    {
        if (! $this->package->hasViews) {
            return $this;
        }

        $namespace = $this->package->viewNamespace;
        $viewsPath = $this->package->basePath(DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views');
        $vendorViews = realpath($viewsPath) ?: $viewsPath;
        $appViews = base_path("resources/views/vendor/{$this->packageView($namespace)}");

        $this->loadViewsFrom($vendorViews, $this->package->viewNamespace());

        if ($this->app->runningInConsole()) {
            $this->publishes([$vendorViews => $appViews], "{$this->packageView($namespace)}-views");
        }

        return $this;
    }
}
