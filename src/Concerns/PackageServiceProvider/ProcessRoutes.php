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
            ->bootLoadRoutesByName()
            ->bootLoadRoutesByPath()
            ->bootPublishRoutesByName()
            ->bootPublishRoutesByPath();
    }

    protected function bootLoadRoutesByName(): self
    {
        if (empty($this->package->routesLoadsFiles)) {
            return $this;
        }

        $routesPath = $this->package->routesPath();
        foreach ($this->package->routesLoadsFiles as $routeFilename) {

            if (is_file("{$routesPath}/{$routeFilename}.php")) {
                $this->loadRoutesFrom("{$routesPath}/{$routeFilename}.php");
            } elseif (!is_file("{$routesPath}/{$routeFilename}.php.stub")){
                throw InvalidPackage::filenameNeitherPhpNorStub(
                    $this->package->name,
                    'Routes',
                    'loadsRoutesByName',
                    $routeFilename
                );
            }
        }

        return $this;
    }

    protected function bootPublishRoutesByName(): self
    {
        if (empty($this->package->routesPublishesFiles) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $routesPath = $this->package->routesPath();
        $tag = $this->package->shortName() . '-routes';
        foreach ($this->package->routesPublishesFiles as $routeFilename) {
            if ($rFN = $this->phpOrStub("{$routesPath}/{$routeFilename}")) {
                $this->publishes(
                    [$rFN => base_path("routes/{$routeFilename}.php")],
                    $tag
                );
            } else {
                throw InvalidPackage::filenameNeitherPhpNorStub(
                    $this->package->name,
                    'Routes',
                    'publishesRoutesByName',
                    $routeFilename
                );
            }
        }

        return $this;
    }

    protected function bootLoadRoutesByPath(): self
    {
        if (empty($this->package->routesLoadsPaths)) {
            return $this;
        }

        foreach ($this->package->routesLoadsPaths as $path) {
            $basePath = $this->package->basePath($path);
            collect(File::allFiles($basePath))->each(function (SplFileInfo $file) use ($basePath) {
                if (is_file($file->getPathname()) and str_ends_with($file->getFilename(), '.php')) {
                    $this->loadRoutesFrom($file->getPathname());
                }
            });
        }

        return $this;
    }

    protected function bootPublishRoutesByPath(): self
    {
        if (empty($this->package->routesPublishesPaths) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $tag = $this->package->shortName() . '-routes';
        $toPath = base_path("routes");
        foreach ($this->package->routesPublishesPaths as $path) {
            $basePath = $this->package->basePath($path);
            collect(File::allFiles($basePath))->each(function (SplFileInfo $file) use ($basePath, $toPath, $tag) {
                $filename = $file->getFilename();
                if (is_file($file->getPathname()) and
                    (str_ends_with($filename, '.php') || str_ends_with($filename, '.php.stub'))
                ) {
                    $toFile = basename($filename);
                    $this->publishes(
                        ["{$basePath}/{$filename}" => "{$toPath}/{$toFile}"],
                        $tag
                    );
                }
            });
        }

        return $this;
    }
}
