<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasInertia
{
    private static string $inertiaComponentsDefaultPath = '../resources/js/Pages';

    public array $inertiaComponentsPublishesPaths = [];

    public function publishesInertiaComponentsByPath(?string $namespace = null, ?string $path = null): self
    {
        $namespace ??= $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->inertiaComponentsPublishesPaths, $namespace);

        $this->inertiaComponentsPublishesPaths[$namespace] =
            $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$inertiaComponentsDefaultPath);

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasInertiaComponents(?string $namespace = null): self
    {
        return $this->publishesInertiaComponentsByPath($namespace);
    }
}
