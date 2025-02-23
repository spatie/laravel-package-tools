<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasRoutes
{
    public array $routeFileNames = [];
    public bool $discoversRoutes = false;
    protected ?string $routesPath = '/../routes';

    public function hasRoutesByName(...$routeFileNames): self
    {
        $this->routeFileNames = array_merge(
            $this->routeFileNames,
            collect($routeFileNames)->flatten()->toArray()
        );

        $this->routesPath = $this->verifyDirOrNull($this->routesPath);

        return $this;
    }

    public function routesPath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->routesPath, $directory);
    }

    public function setRoutesPath(string $path): self
    {
        $this->routesPath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasRoute(...$routeFileNames): self
    {
        return $this->hasRoutesByName(...$routeFileNames);
    }

    public function hasRoutes(...$routeFileNames): self
    {
        return $this->hasRoutesByName(...$routeFileNames);
    }
}
