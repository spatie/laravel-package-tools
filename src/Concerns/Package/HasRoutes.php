<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasRoutes
{
    private const routesDefaultPath = '../routes';

    public array $routeFilenames = [];
    public array $routesPaths = [];
    protected string $routesPath = '../routes';

    public function hasRoutesByName(...$routeFilenames): self
    {
        $this->routeFilenames = array_unique(array_merge(
            $this->routeFilenames,
            collect($routeFilenames)->flatten()->toArray()
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

    public function hasRoutesByPath(?string $path = null): self
    {
        $this->routesPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::routesDefaultPath);

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasRoute(...$routeFilenames): self
    {
        return $this->hasRoutesByName(...$routeFilenames);
    }

    public function hasRoutes(...$routeFilenames): self
    {
        return $this->hasRoutesByName(...$routeFilenames);
    }
}
