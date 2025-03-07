<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

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
        $this->verifyUniqueKey(__FUNCTION__, 'prefix', $this->bladeComponentNamespaces, $prefix);
        $this->bladeComponentNamespaces[$prefix] = $viewComponentNamespace;

        return $this;
    }

    public function hasBladeComponentsByPath(string $prefix, ?string $path = null): self
    {
        $this->verifyUniqueKey(__FUNCTION__, 'prefix', $this->bladeComponentPaths, $prefix);
        $this->bladeComponentPaths[$prefix] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$bladeComponentsDefaultPath);

        return $this;
    }

    public function hasBladeAnonymousComponentsByPath(string $prefix, ?string $path = null): self
    {
        if (version_compare(App::version(), '9.44.0') < 0) {
            throw InvalidPackage::laravelFunctionalityNotYetImplemented(
                $this->name,
                __FUNCTION__,
                '9.44.0'
            );
        }

        $this->verifyUniqueKey(__FUNCTION__, 'prefix', $this->bladeAnonymousComponentPaths, $prefix);
        $this->bladeAnonymousComponentPaths[$prefix] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$bladeAnonymousComponentsDefaultPath);

        return $this;
    }

    public function hasBladeCustomDirective(string $name, callable $callable): self
    {
        $this->verifyUniqueKey(__FUNCTION__, 'custom directive', $this->bladeDirectives, $name);
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
        $this->verifyUniqueKey(__FUNCTION__, 'custom If', $this->bladeIfs, $name);
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
