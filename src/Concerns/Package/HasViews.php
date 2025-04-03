<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasViews
{
    private static string $viewsDefaultPath = '../resources/views';

    public array $viewsLoadsPaths = [];
    public array $viewsPublishesPaths = [];

    public function loadsViewsByPath(?string $namespace = null, ?string $path = null): self
    {
        $namespace = $namespace ?? $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->viewsLoadsPaths, $namespace);

        $this->viewsLoadsPaths[$namespace] =
            $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$viewsDefaultPath);

        return $this;
    }

    public function publishesViewsByPath(?string $namespace = null, ?string $path = null): self
    {
        $namespace = $namespace ?? $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->viewsPublishesPaths, $namespace);

        $this->viewsPublishesPaths[$namespace] =
            $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$viewsDefaultPath);

        return $this;
    }

    public function hasViews(?string $namespace = null): self
    {
        return $this
            ->loadsViewsByPath($namespace)
            ->publishesViewsByPath($namespace);
    }
}
