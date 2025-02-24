<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasBlade
{
    public array $bladeComponents = [];
    public array $bladeComponentNamespaces = [];
    public array $bladeComponentPaths = [];
    public array $bladeDirectives = [];
    public array $bladeEchos = [];
    public array $bladeIfs = [];

    public function hasBladeComponentsByClass(string $prefix, ...$bladeComponentNames): self
    {
        $bladeComponentNames = collect($bladeComponentNames)->flatten()->toArray();

        $this->verifyClassNames(__FUNCTION__, $bladeComponentNames);

        if (array_key_exists($prefix, $this->bladeComponents)) {
            $this->bladeComponents[$prefix] = array_merge($this->bladeComponents[$prefix], $bladeComponentNames);
        } else {
            $this->bladeComponents[$prefix] = $bladeComponentNames;
        }

        return $this;
    }

    public function hasBladeComponentsByNamespace(string $prefix, string $viewComponentNamespace): self
    {
        $this->bladeComponentNamespaces[$prefix] = $viewComponentNamespace;

        return $this;
    }

    public function hasBladeComponentsByPath(string $prefix, string $path): self
    {
        $this->bladeComponentPaths[$prefix] = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }

    public function hasBladeCustomDirective(string $name, callable $callable): self
    {

        $this->bladeDirectives[$name] = $callable;

        return $this;
    }

    public function hasBladeCustomEchoHandler(callable $callable): self
    {
        $this->bladeEchos[] = $callable;

        return $this;
    }

    public function hasBladeCustomIf(string $name, callable $callable): self
    {
        $this->bladeIfs[$name] = $callable;

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasViewComponent(string $prefix, ...$viewComponentNames): self
    {
        return $this->hasBladeComponentsByClass($prefix, ...$viewComponentNames);
    }

    public function hasViewComponents(string $prefix, ...$viewComponentNames): self
    {
        return $this->hasBladeComponentsByClass($prefix, ...$viewComponentNames);
    }
}
