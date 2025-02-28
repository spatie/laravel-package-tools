<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasBlade
{
    private static string $bladeComponentsDefaultPath = "Components";
    private static string $bladeAnonymousComponentsDefaultPath = "../resources/views/components";

    public array $bladeComponents = [];
    public array $bladeComponentNamespaces = [];
    public array $bladeComponentPaths = [];
    public array $bladeAnonymousComponentPaths = [];
    public array $bladeDirectives = [];
    public array $bladeEchos = [];
    public array $bladeIfs = [];

    public function hasBladeComponentsByClass(string $prefix, ...$bladeComponentNames): self
    {
        $bladeComponentNames = $this->verifyClassNames(__FUNCTION__, collect($bladeComponentNames)->flatten()->toArray());

        if (array_key_exists($prefix, $this->bladeComponents)) {
            $this->bladeComponents[$prefix] = array_unique(array_merge($this->bladeComponents[$prefix], $bladeComponentNames));
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

    public function hasBladeComponentsByPath(string $prefix, ?string $path = null): self
    {
        $this->bladeComponentPaths[$prefix] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$bladeComponentsDefaultPath);

        return $this;
    }

    public function hasBladeAnonymousComponentsByPath(string $prefix, ?string $path = null): self
    {
        $this->bladeAnonymousComponentPaths[$prefix] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$bladeAnonymousComponentsDefaultPath);

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
