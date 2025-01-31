<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasRoutes
{
    public array $routeFileNames = [];
    public bool $discoversRoutes = false;
    protected string $routesPath = '/../routes';

    public function hasRoutes(...$routeFileNames): self
    {
        $this->routeFileNames = array_merge(
            $this->routeFileNames,
            collect($routeFileNames)->flatten()->toArray()
        );

        return $this;
    }

    public function hasRoute(...$routeFileNames): self
    {
        return $this->hasRoutes(...$routeFileNames);
    }

    public function routesPath(?string $directory = null): string
    {
        return $this->buildDirectory($this->routesPath, $directory);
    }

    public function setRoutesPath(string $path): self
    {
        $this->verifyDir($this->buildDirectory($path));
        $this->routesPath = $path;

        return $this;
    }

    public function discoversRoutes(bool $discoversRoutes = true, ?string $path = null): self
    {
        $this->discoversRoutes = $discoversRoutes;
        $this->routesPath = $path ?? $this->routesPath;

        return $this;
    }
}
