<?php

namespace Spatie\LaravelPackageTools\Traits;

trait HasInertia
{
    public bool $hasInertiaComponents = false;

    public function hasInertiaComponents(string $namespace = null): static
    {
        $this->hasInertiaComponents = true;

        $this->viewNamespace = $namespace;

        return $this;
    }
}
