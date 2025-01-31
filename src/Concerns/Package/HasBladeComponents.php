<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasBladeComponents
{
    public array $bladeComponents = [];
    public array $bladeComponentNamespaces = [];
    public array $bladeComponentPaths = [];

    public function hasBladeComponents(string $prefix, ...$bladeComponentNames): self
    {
        $bladeComponentNames = collect($bladeComponentNames)->flatten()->toArray();

        if (array_key_exists($prefix, $this->bladeComponents)) {
            $this->bladeComponents[$prefix] = array_merge($this->bladeComponents[$prefix], $bladeComponentNames);
        } else {
            $this->bladeComponents[$prefix] = $bladeComponentNames;
        }

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasViewComponent(string $prefix, ...$viewComponentNames): self
    {
        return $this->hasBladeComponents($prefix, ...$viewComponentNames);
    }

    public function hasViewComponents(string $prefix, ...$viewComponentNames): self
    {
        return $this->hasBladeComponents($prefix, ...$viewComponentNames);
    }

    public function hasBladeComponentNamespaces(string $prefix, string $viewComponentNamespace): self
    {
        $this->bladeComponentNamespaces[$prefix] = $viewComponentNamespace;

        return $this;
    }

    public function hasBladeComponentPaths(string $prefix, string $path): self
    {
        $this->bladeComponentPaths[$prefix] = $path;

        return $this;
    }
}
