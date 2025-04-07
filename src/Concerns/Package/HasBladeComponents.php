<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait HasBladeComponents
{
    private static string $bladeComponentsDefaultPath = "Components";

    public array $bladeLoadsComponentClasses = [];
    public array $bladePublishesComponentClasses = [];
    public array $bladeLoadsComponentNamespaces = [];
    public array $bladeLoadsComponentPaths = [];
    public array $bladePublishesComponentPaths = [];

    public function loadsBladeComponentsByClass(string $prefix, ...$classes): self
    {
        return $this->handlesBladeComponentsByClass(__FUNCTION__, $this->bladeLoadsComponentClasses, $prefix, ...$classes);
    }

    public function publishesBladeComponentsByClass(string $prefix, ...$classes): self
    {
        return $this->handlesBladeComponentsByClass(__FUNCTION__, $this->bladePublishesComponentClasses, $prefix, ...$classes);
    }

    protected function handlesBladeComponentsByClass(string $method, array &$paths, string $prefix, ...$classes): self
    {
        $classes = $this->verifyClassNames($method, collect($classes)->flatten()->toArray());

        if (empty($classes)) {
            throw InvalidPackage::emptyParameter(
                $this->name,
                $method,
                'classes'
            );
        }

        if (array_key_exists($prefix, $paths)) {
            $paths[$prefix] = array_unique(array_merge($paths[$prefix], $classes));
        } else {
            $paths[$prefix] = $classes;
        }

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasViewComponent(string $prefix, string $viewComponentName): self
    {
        return $this->hasViewComponents($prefix, $viewComponentName);
    }

    public function hasViewComponents(string $prefix, ...$viewComponentNames): self
    {
        return $this
            ->loadsBladeComponentsByClass($prefix, ...$viewComponentNames)
            ->publishesBladeComponentsByClass($prefix, ...$viewComponentNames);
    }

    /**********************************************************************************
     * Blade View Components By Namespace
     **********************************************************************************/
    public function loadsBladeComponentsByNamespace(string $prefix, string $namespace): self
    {
        $this->verifyUniqueKey(__FUNCTION__, 'prefix', $this->bladeLoadsComponentNamespaces, $prefix);
        $this->bladeLoadsComponentNamespaces[$prefix] = $namespace;

        return $this;
    }

    /**********************************************************************************
     * Blade View Components By Path
     **********************************************************************************/
    public function loadsBladeComponentsByPath(?string $prefix = null, ?string $path = null): self
    {
        return $this->handlesBladeComponentsByPath(__FUNCTION__, $this->bladeLoadsComponentPaths, $prefix, $path);
    }

    public function publishesBladeComponentsByPath(?string $prefix = null, ?string $path = null): self
    {
        return $this->handlesBladeComponentsByPath(__FUNCTION__, $this->bladePublishesComponentPaths, $prefix, $path);
    }

    protected function handlesBladeComponentsByPath(string $method, array &$paths, ?string $prefix, ?string $path): self
    {
        $prefix ??= $this->shortName();
        $this->verifyUniqueKey($method, 'prefix', $paths, $prefix);
        $paths[$prefix] = $this->verifyRelativeDir($method, $path ?? static::$bladeComponentsDefaultPath);

        return $this;
    }
}
