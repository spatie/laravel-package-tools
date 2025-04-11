<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait PackageServiceProviderHelpers
{
    private function phpOrStub(string $filename): string
    {
        if (is_file($file = $filename . '.php')) {
            return $file;
        }

        if (is_file($file = $filename . '.php.stub')) {
            return $file;
        }

        return "";
    }

    private function existingFile(string $file): string
    {
        if (is_file($file)) {
            return $file;
        }

        return "";
    }

    // Get namespace for directory from the first class file in the directory
    private function getNamespaceOfRelativePath($path): string
    {
        return $this->getNamespaceOfPath($this->package->buildDirectory($path));
    }

    // Get namespace for directory from the first class file in the directory
    private function getNamespaceOfPath($path): string
    {
        foreach (glob($path . '/*.php') as $file) {
            if ($namespace = $this->readNamespaceFromFile($file)) {
                return $namespace;
            }
        }

        throw InvalidPackage::cannotDetermineNamespace(
            $this->package->name,
            'hasBladeComponentsByPath',
            $path
        );
    }

    private function readNamespaceFromFile($file): string
    {
        $namespace = "";
        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $parts = explode(' ', trim($line));
                if ($parts[0] === 'namespace') {
                    $namespace = rtrim(trim($parts[1]), ';');

                    break;
                }
            }
            fclose($handle);

            return $namespace;
        }

        return "";
    }

    private function getClassesInPaths(string $method, ...$paths): array
    {
        $classes = [];
        foreach (collect($paths)->flatten()->toArray() as $path) {
            $path = $this->package->buildDirectory($path);
            $namespace = $this->getNamespaceOfPath($path);
            $pathClasses = [];

            foreach (File::allfiles($path) as $file) {
                if (! str_ends_with($filename = $file->getPathname(), '.php')) {
                    continue;
                }
                $pathClasses[] = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($filename, $path)
                );
            }

            if (empty($pathClasses)) {
                throw InvalidPackage::pathDoesNotContainClasses(
                    $this->package->name,
                    $method,
                    $path
                );
            }

            $classes = array_unique(array_merge($classes, $pathClasses));
        }

        $this->package->verifyClassNames($method, $classes);

        return $classes;
    }
}
