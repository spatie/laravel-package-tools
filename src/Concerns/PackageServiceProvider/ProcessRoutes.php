<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait ProcessRoutes
{
    protected function bootPackageRoutes(): self
    {

        if (empty($this->package->routeFileNames)) {
            return $this;
        }

        foreach ($this->package->routeFileNames as $routeFileName) {
            $this->loadRoutesFrom("{$this->package->routesPath()}/{$routeFileName}.php");
        }

        return $this;
    }
}
