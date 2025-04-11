<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait PackageHelpers
{
    public bool $throwInvalidPackage = true;

    public function buildDirectory(string $path, ?string $directory = null): string
    {
        return $this->appendDirectory($this->basePath($path), $directory);
    }

    private function appendDirectory(string $basePath, ?string $directory = null): string
    {
        if ($directory === null) {
            return $basePath;
        }

        return $basePath . DIRECTORY_SEPARATOR . trim($directory, '/\\');
    }

    public function verifyClassNames(string $method, ...$classes): array
    {
        $classes = collect($classes)->flatten()->toArray();

        /* Avoid autoloading classes if production */
        if (! env('APP_DEBUG', false)) {
            return $classes;
        }

        foreach ($classes as $class) {
            if (! class_exists($class)) {
                throw InvalidPackage::classDoesNotExist(
                    $this->name,
                    $method,
                    $class
                );
            }
        }

        return $classes;
    }

    public function verifyClassMethod(string $method, $class, $classMethod): string
    {
        if (method_exists($class, $classMethod) || method_exists($class, "__invoke")) {
            return $classMethod;
        }

        throw InvalidPackage::classMethodDoesNotExist(
            $this->name,
            $method,
            'Listener',
            Str::afterLast($class, "\\"),
            $classMethod
        );
    }

    private function verifyRelativeFile(string $method, string $file): string
    {
        return $this->verifyFile($method, $this->buildDirectory($file), $file);
    }

    private function verifyFile(string $method, string $file, string $relativeFile = null): string
    {
        /* Avoid exceptions if production */
        if (! env('APP_DEBUG', false)) {
            return $file;
        }

        if (! is_file($file)) {
            throw InvalidPackage::fileDoesNotExist(
                $this->name,
                $method,
                $relativeFile ?? $file
            );
        }

        return $file;
    }

    private function verifyFiles(string $method, string ...$files): void
    {
        // ToDo: Is this actually used? Need to use some sort of path with this.
        /* Avoid exceptions if production */
        if (! env('APP_DEBUG', false)) {
            return;
        }

        foreach (collect($files)->flatten()->toArray() as $file) {
            if (! is_file($this->buildDirectory($file))) {
                throw InvalidPackage::fileDoesNotExist(
                    $this->name,
                    $method,
                    $file
                );
            }
        }
    }

    private function verifyDir(string $method, string $dir): string
    {
        /* Avoid exceptions if production */
        if (! env('APP_DEBUG', false)) {
            return $dir;
        }

        if (! is_dir($dir)) {
            throw InvalidPackage::dirDoesNotExist(
                $this->name,
                $method,
                $dir
            );
        }

        return $dir;
    }

    private function verifyRelativeDir(string $method, string $dir): string
    {
        /* Avoid exceptions if production */
        if (! env('APP_DEBUG', false)) {
            return $dir;
        }

        if (! is_dir($this->basePath($dir))) {
            throw InvalidPackage::dirDoesNotExist(
                $this->name,
                $method,
                $dir
            );
        }

        return $dir;
    }

    private function verifyRelativeDirs(string $method, array $dirs): void
    {
        foreach ($dirs as $dir) {
            $this->verifyDir($method, $this->basePath($dir));
        }
    }

    private function verifyRelativeDirOrNull(string $dir): string
    {
        return is_dir($this->basePath($dir)) ? $dir : null;
    }

    private function verifyPathSet(string $method, string $path, ?string $subpath = null): string
    {
        // ToDo: Eventually this won't be used
        if (! $path) {
            throw InvalidPackage::defaultPathDoesNotExist(
                $this->name,
                $method
            );
        }

        return $this->buildDirectory($path, $subpath);
    }

    private function verifyUniqueKey(string $method, string $type, array $currentArray, string $proposedKey): string
    {
        if (array_key_exists($proposedKey, $currentArray)) {
            throw InvalidPackage::duplicateNamespace(
                $this->name,
                $method,
                $type,
                $proposedKey
            );
        }

        return $proposedKey;
    }

    public function studlyCase(string $text): string
    {
        return Str::of($text)->studly()->value();
    }
}
