<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Illuminate\Support\Facades\Blade;
use ReflectionClass;
use Spatie\LaravelPackageTools\Package;

trait ProcessBladeComponents
{
    protected function bootPackageBladeComponents(): self
    {
        return $this
            ->bootLoadsBladeComponentsByClass()
            ->bootPublishesBladeComponentsByClass()
            ->bootLoadsBladeComponentsByNamespace()
            ->bootLoadsBladeComponentsByPath()
            ->bootPublishesBladeComponentsByPath();
    }

    /**********************************************************************************
     * Blade View Components By Class
     **********************************************************************************/
    protected function bootLoadsBladeComponentsByClass(): self
    {
        if (empty($this->package->bladeLoadsComponentClasses)) {
            return $this;
        }

        foreach ($this->package->bladeLoadsComponentClasses as $prefix => $componentClasses) {
            $this->loadViewComponentsAs($prefix, $componentClasses);
        }

        return $this;
    }

    protected function bootPublishesBladeComponentsByClass(): self
    {
        if (empty($this->package->bladePublishesComponentClasses) || ! $this->app->runningInConsole()) {
            return $this;
        }

        /**********************************************************************************
         * Fix for https://github.com/spatie/laravel-package-tools/issues/151
         *
         * 1. Publish component classes individually rather than as a directory
         * 2. Get the classes location using redirection
         *
         * Blade components can also now be loaded by path using `loadsBladeComponentsByPath`
         * and made publishable by path using `publishesBladeComponentsByPath`.
         **********************************************************************************/
        $appPath = app_path("View/Components/vendor/{$this->package->shortName()}/");

        /* Legacy fix - publish as both standardised {$this->package->shortName()} and legacy {$this->package->name} */
        $shortTag = "{$this->package->shortName()}-components";
        $longTag = "{$this->package->name}-components";

        foreach (collect($this->package->bladePublishesComponentClasses)->flatten()->toArray() as $componentClass) {
            $filename = (new ReflectionClass($componentClass))->getFileName();
            $this->publishes(
                [$filename => $appPath . basename($filename)],
                $shortTag
            );

            if ($shortTag === $longTag) {
                continue;
            }

            $this->publishes(
                [$filename => $appPath . basename($filename)],
                $longTag
            );
        }

        return $this;
    }

    /**********************************************************************************
     * Blade View Components By Namespace
     **********************************************************************************/
    protected function bootLoadsBladeComponentsByNamespace(): self
    {
        if (empty($this->package->bladeLoadsComponentNamespaces)) {
            return $this;
        }

        foreach ($this->package->bladeLoadsComponentNamespaces as $prefix => $namespace) {
            Blade::componentNamespace($namespace, $prefix);
        }

        return $this;
    }

    /**
     * Ideally we would also allow users to publish components by namespace,
     * however even though it is easy to get the path of an object using reflection,
     * it is not easy to discover an object in a namespace in order to determine the path,
     * and so not easy to determine the path associated with a namespace.
     *
     * If needed, this might be possible in the future by querying composer autoloads,
     * but for the moment this is a documented restriction.
     **/

    protected function bootLoadsBladeComponentsByPath(): self
    {
        if (empty($paths = $this->package->bladeLoadsComponentPaths)) {
            return $this;
        }

        foreach ($paths as $prefix => $path) {
            // Get namespace for directory from the first class file in the directory
            // Load the namespace
            Blade::componentNamespace($this->getNamespaceOfRelativePath($path), $prefix);
        }

        return $this;
    }

    protected function bootPublishesBladeComponentsByPath(): self
    {
        if (empty($paths = $this->package->bladePublishesComponentPaths) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $appPath = app_path("View/Components/vendor/{$this->package->shortName()}/");
        $tag = "{$this->package->shortName()}-components";
        foreach ($paths as $prefix => $path) {
            $this->publishes(
                [$this->package->basePath($path) => $appPath],
                $tag
            );
        }

        return $this;
    }
}
