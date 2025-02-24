<?php

namespace Spatie\LaravelPackageTools\Exceptions;

use Exception;

class InvalidPackage extends Exception
{
    public static function nameIsRequired(): self
    {
        return new static('This package does not have a name. You can set one with `$package->name("yourName")`');
    }

    public static function conflictingMethods(string $packageName, string $method1, string $method2): self
    {
        return new static("Package $packageName has conflicting methods - use one or the other not both: $method1, $method2");
    }

    public static function fileDoesNotExist(string $packageName, string $method, string $file): self
    {
        return new static("$method: File '$file' does not exist in package $packageName");
    }

    public static function dirDoesNotExist(string $packageName, string $method, string $dir): self
    {
        return new static("$method: Directory '$dir' does not exist in package $packageName");
    }

    public static function classDoesNotExist(string $packageName, string $method, string $class): self
    {
        return new static("$method: Class '$class' does not exist in package $packageName");
    }

    public static function cannotDetermineNamespace(string $packageName, string $method, string $path): self
    {
        return new static("$method: Unable to determine namespace from files for '$path' in package $packageName");
    }

    public static function defaultPathDoesNotExist(string $packageName, string $method): self
    {
        return new static("The default path for $method doesn't exist. Create it or set an alternative path in package $packageName");
    }

    public static function pathDoesNotContainClasses(string $packageName, string $method, string $path): self
    {
        return new static("$method: Path '$path' does not contain any classes in package $packageName");
    }

    public static function filenameNeitherPhpNorStub(string $packageName, string $type, string $filename): self
    {
        return new static("$type filename '$filename' is neither .php or .php.stub in package $packageName");
    }
}
