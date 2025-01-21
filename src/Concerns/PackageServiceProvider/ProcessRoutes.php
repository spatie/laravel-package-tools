<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessRoutes
{
    protected function bootRoutes()
    {
        if (empty($this->package->routeFileNames)) {
            return;
        }

        foreach ($this->package->routeFileNames as $routeFileName) {
            $this->loadRoutesFrom("{$this->package->basePath('/../routes/')}{$routeFileName}.php");
        }
    }
}
