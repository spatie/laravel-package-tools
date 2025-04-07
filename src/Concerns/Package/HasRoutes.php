<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasRoutes
{
    private static string $routesDefaultPath = '../routes';

    public array $routesLoadsFiles = [];
    public array $routesLoadsPaths = [];
    public array $routesPublishesFiles = [];
    public array $routesPublishesPaths = [];
    protected string $routesPath = '../routes';

    public function loadsRoutesByName(...$routesFiles): self
    {
        $this->routesLoadsFiles = array_unique(array_merge(
            $this->routesLoadsFiles,
            collect($routesFiles)->flatten()->toArray()
        ));

        $this->routesPath = $this->verifyRelativeDirOrNull($this->routesPath);

        return $this;
    }

    public function publishesRoutesByName(...$routesFiles): self
    {
        $this->routesPublishesFiles = array_unique(array_merge(
            $this->routesPublishesFiles,
            collect($routesFiles)->flatten()->toArray()
        ));

        $this->routesPath = $this->verifyRelativeDirOrNull($this->routesPath);

        return $this;
    }

    public function setRoutesByNamePath(string $path): self
    {
        $this->routesPath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }

    public function routesPath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->routesPath, $directory);
    }

    public function loadsRoutesByPath(?string $path = null): self
    {
        $this->routesLoadsPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$routesDefaultPath);

        return $this;
    }

    public function publishesRoutesByPath(?string $path = null): self
    {
        $this->routesPublishesPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$routesDefaultPath);

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasRoute(string $routeFileName): self
    {
        return $this->hasRoutes($routeFileName);
    }

    public function hasRoutes(...$routesFileNames): self
    {
        return $this->loadsRoutesByName(...$routesFileNames);

        return $this->publishesRoutesByName(...$routesFileNames);
    }
}
