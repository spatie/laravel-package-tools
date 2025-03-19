<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Illuminate\Support\Facades\File;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Symfony\Component\Finder\SplFileInfo;

trait ProcessRoutes
{
    public function bootPackageRoutes(): self
    {
        return $this
            ->bootPackageRoutesByName()
            ->bootPackageRoutesByPath();
    }

    protected function bootPackageRoutesByName(): self
    {
        if (empty($this->package->routeFilenames)) {
            return $this;
        }

        $routesPath = $this->package->routesPath();
        foreach ($this->package->routeFilenames as $routeFilename) {

            if (is_file("{$routesPath}/{$routeFilename}.php")) {
                $this->loadRoutesFrom("{$routesPath}/{$routeFilename}.php");
            }
        }

        if (! $this->app->runningInConsole()) {
            return $this;
        }

        $tag = $this->package->shortName() . '-routes';
        foreach ($this->package->routeFilenames as $routeFilename) {
            if ($rFN = $this->phpOrStub("{$routesPath}/{$routeFilename}")) {
                $this->publishes(
                    [$rFN => base_path("routes/{$routeFilename}.php")],
                    $tag
                );
            } else {
                throw InvalidPackage::filenameNeitherPhpNorStub(
                    $this->package->name,
                    'Routes',
                    'hasRoutesByName',
                    $routeFilename
                );
            }
        }

        return $this;
    }

    protected function bootPackageRoutesByPath(): self
    {
        if (empty($this->package->routesPaths)) {
            return $this;
        }

        foreach ($this->package->routesPaths as $path) {
            $basePath = $this->package->basePath($path);
            collect(File::allFiles($basePath))->each(function (SplFileInfo $file) use ($basePath) {
                if (is_file($file->getPathname()) and str_ends_with($file->getFilename(), '.php')) {
                    $this->loadRoutesFrom($file->getPathname());
                }
            });
        }

        if (! $this->app->runningInConsole()) {
            return $this;
        }

        $tag = $this->package->shortName() . '-routes';
        foreach ($this->package->routesPaths as $path) {
            $this->publishes(
                [$this->package->basePath($path) => base_path("routes")],
                $tag
            );
        }

        return $this;
    }
}
