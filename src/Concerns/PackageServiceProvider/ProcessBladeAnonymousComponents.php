<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Illuminate\Support\Facades\Blade;
use ReflectionClass;
use Spatie\LaravelPackageTools\Package;

trait ProcessBladeAnonymousComponents
{
    protected function bootPackageBladeAnonymousComponents(): self
    {
        return $this
            ->bootLoadsBladeAnonymousComponentsByPath();
    }

    protected function bootLoadsBladeAnonymousComponentsByPath(): self
    {
        if (empty($paths = $this->package->bladeLoadsAnonymousComponentsPaths)) {
            return $this;
        }

        foreach ($paths as $prefix => $path) {
            if ($prefix === Package::$bladeAnonymousComponentsDefaultPrefix) {
                $prefix = null;
            }

            Blade::anonymousComponentPath($this->package->buildDirectory($path), $prefix);
        }

        return $this;
    }
}
