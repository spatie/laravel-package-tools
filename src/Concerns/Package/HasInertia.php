<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasInertia
{
    private static string $inertiaComponentsDefaultPath = '../resources/js/Pages';

    public array $inertiaComponentsPaths = [];

    public function hasInertiaComponents(?string $namespace = null, ?string $path = null): self
    {

        $namespace = $namespace ?? $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->inertiaComponentsPaths, $namespace);

        $this->inertiaComponentsPaths[$namespace] =
            $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$inertiaComponentsDefaultPath);

        return $this;
    }
}
