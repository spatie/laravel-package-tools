<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use PhpToken;
use ReflectionClass;

trait ProcessBladeComponents
{
    protected function bootPackageBladeComponents(): self
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

    protected function bootPackageBladeComponentNamespaces(): self
    {
        if (empty($this->package->bladeComponentNamespaces)) {
            return $this;
        }

        return $this->bladeLoadComponentNamespaces($this->package->bladeComponentNamespaces);

        /**
         * Ideally this method would also publish the files in a namespace,
         * however even though it is easy to get the path of an object using reflection,
         * it is not easy to discover an object in a namespace,
         * and so not easy to determine the path associated with a namespace.
         *
         * If needed, this might be possible in the future by querying composer autoloads,
         * but for the moment this is a documented restruction.
         **/

    }

    protected function bootPackageBladeComponentPaths(): self
    {
        if (empty($this->package->bladeComponentPaths)) {
            return $this;
        }

        $namespaces = [];
        foreach ($this->package->bladeComponentPaths as $prefix => $path) {
            // Get namespace for directory from the first class file in the directory
            // Load the namespace
            foreach (glob($path . '/*.php') as $file) {
                if ($namespace = getNamespaceFromFile($file)) {
                    $namespaces[$prefix] = $namespace;
                    break;
                }
            }
        }
        $this->bladeLoadComponentNamespaces($namespaces);

        if (! $this->app->runningInConsole()) {
            return $this;
        }

        $appPath = app_path("View/Components/vendor/{$this->package->shortName()}/");
        $tag = "{$this->package->shortName()}-components";
        foreach ($this->package->bladeComponentPaths as $prefix => $path) {
            $this->publishes(
                [$this->package->basePath($path) => $appPath . basename($path)],
                $tag
            );
        }

        return $this;
    }

    private function bladeLoadComponentNamespaces(array $namespaces): self
    {
        foreach ($namespaces as $prefix => $namespace) {
            Blade::componentNamespace($namespace, $prefix);
        }

        return $this;
    }

    private static function getNamespaceFromFile($file): string
    {
        $tokens = PhpToken::tokenize(file_get_contents($file));
        $namespace = [];
        foreach ($tokens as $index => $token) {
            if ($token->is(T_NAMESPACE) && $tokens[$index+2]->is(T_STRING)){
                for ($i = $index+2 ;!$tokens[$i]->is(T_WHITESPACE);$i++){
                    if ($tokens[$i]->text === ";"){
                        continue;
                    }
                    $namespace[] = $tokens[$i]->text;
                }
                return implode('',$namespace)."\\";
            }
        }
        return "";
    }
}
