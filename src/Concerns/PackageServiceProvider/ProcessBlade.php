<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Illuminate\Support\Facades\Blade;
use ReflectionClass;

trait ProcessBlade
{
    protected function bootPackageBlade(): self
    {
        $this
            ->bootPackageBladeComponentsByClass()
            ->bootPackageBladeComponentsByNamespace()
            ->bootPackageBladeComponentsByPath()
            ->bootPackageBladeAnonymousComponentsByPath()
            ->bootPackageBladeDirectives()
            ->bootPackageBladeEchos()
            ->bootPackageBladeIfs();

        return $this;
    }

    protected function bootPackageBladeComponentsByClass(): self
    {
        if (empty($this->package->bladeComponents)) {
            return $this;
        }

        foreach ($this->package->bladeComponents as $prefix => $componentClasses) {
            $this->loadViewComponentsAs($prefix, $componentClasses);
        }

        if (! $this->app->runningInConsole()) {
            return $this;
        }

        /* Fix for https://github.com/spatie/laravel-package-tools/issues/151 */
        /**
         * Publish component classes individually rather than as a directory
         * Blade components can also now be loaded and published by path using `hasBladeComponentPath`
         **/
        $appPath = app_path("View/Components/vendor/{$this->package->shortName()}/");
        $tag = "{$this->package->name}-components";

        foreach (collect($this->package->bladeComponents)->flatten()->toArray() as $componentClass) {
            $filename = (new ReflectionClass($componentClass))->getFileName();
            $this->publishes(
                [$filename => $appPath . basename($filename)],
                $tag
            );
        }

        return $this;
    }

    protected function bootPackageBladeComponentsByNamespace(): self
    {
        if (empty($this->package->bladeComponentNamespaces)) {
            return $this;
        }

        foreach ($this->package->bladeComponentNamespaces as $prefix => $namespace) {
            Blade::componentNamespace($namespace, $prefix);
        }

        return $this;

        /**
         * Ideally this method would also publish the files in a namespace,
         * however even though it is easy to get the path of an object using reflection,
         * it is not easy to discover an object in a namespace in order to determine the path,
         * and so not easy to determine the path associated with a namespace.
         *
         * If needed, this might be possible in the future by querying composer autoloads,
         * but for the moment this is a documented restriction.
         **/

    }

    protected function bootPackageBladeComponentsByPath(): self
    {
        if (empty($paths = $this->package->bladeComponentPaths)) {
            return $this;
        }

        foreach ($paths as $prefix => $path) {
            // Get namespace for directory from the first class file in the directory
            // Load the namespace
            Blade::componentNamespace($this->getNamespaceOfRelativePath($path), $prefix);
        }

        if (! $this->app->runningInConsole()) {
            return $this;
        }

        $appPath = app_path("View/Components/vendor/{$this->package->shortName()}/");
        $tag = "{$this->package->name}-components";
        foreach ($paths as $prefix => $path) {
            $this->publishes(
                [$this->package->basePath($path) => $appPath],
                $tag
            );
        }

        return $this;
    }

    protected function bootPackageBladeAnonymousComponentsByPath(): self
    {
        if (empty($paths = $this->package->bladeAnonymousComponentPaths)) {
            return $this;
        }

        foreach ($paths as $prefix => $path) {
            // Get namespace for directory from the first class file in the directory
            Blade::anonymousComponentPath($this->package->buildDirectory($path), $prefix);
        }

        if (! $this->app->runningInConsole()) {
            return $this;
        }

        $appPath = resource_path("views/components/vendor/{$this->package->shortName()}/");
        $tag = "{$this->package->name}-anonymous-components";
        foreach ($paths as $prefix => $path) {
            $this->publishes(
                [$this->package->basePath($path) => $appPath],
                $tag
            );
        }

        return $this;
    }

    protected function bootPackageBladeDirectives(): self
    {
        if (empty($this->package->bladeDirectives)) {
            return $this;
        }

        foreach ($this->package->bladeEchos as $name => $callable) {
            Blade::directive($name, $callable);
        }

        return $this;
    }

    protected function bootPackageBladeEchos(): self
    {
        if (empty($this->package->bladeEchos)) {
            return $this;
        }

        foreach ($this->package->bladeEchos as $callable) {
            Blade::stringable($callable);
        }

        return $this;
    }

    protected function bootPackageBladeIfs(): self
    {
        if (empty($this->package->bladeIfs)) {
            return $this;
        }

        foreach ($this->package->bladeIfs as $name => $callable) {
            Blade::if($name, $callable);
        }

        return $this;
    }
}
