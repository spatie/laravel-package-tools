<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

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
