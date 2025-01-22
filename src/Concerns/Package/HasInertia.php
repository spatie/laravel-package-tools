<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasInertia
{
    public bool $hasInertiaComponents = false;

    public function hasInertiaComponents(?string $namespace = null): self
    {
        $this->hasInertiaComponents = true;

        $this->viewNamespace = $namespace;

        return $this;
    }
}
