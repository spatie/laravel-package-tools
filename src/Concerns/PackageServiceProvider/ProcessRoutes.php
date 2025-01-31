<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessRoutes
{
    protected function bootPackageRoutes(): self
    {

        if ($this->package->discoversRoutes) {
            if (! empty($this->package->routeFileNames)) {
                throw InvalidPackage::conflictingMethods(
                    $this->package->name,
                    'hasRoutes',
                    'discoversRoutes'
                );
            }

            $this->package->routeFileNames = $this->convertDiscovers($this->package->routesPath());
        }

        if (empty($this->package->routeFileNames)) {
            return $this;
        }

        foreach ($this->package->routeFileNames as $routeFileName) {
            $this->loadRoutesFrom("{$this->package->routesPath()}/{$routeFileName}.php");
        }

        return $this;
    }
}
