<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasViews
{
    private const viewsDefaultPath = '../resources/views';

    public array $viewsPaths = [];

    public function hasViews(?string $namespace = null, ?string $path = null): self
    {
        $namespace = $namespace ?? $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->viewsPaths, $namespace);

        $this->viewsPaths[$namespace] =
            $this->verifyRelativeDir(__FUNCTION__, $path ?? static::viewsDefaultPath);

        return $this;
    }
}
