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

    public static function classMethodDoesNotExist(string $packageName, string $method, string $type, string $class, string $classMethod): self
    {
        return new static("$method: $type '$class' does not have method '$classMethod' in package $packageName");
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

    public static function filenameNeitherPhpNorStub(string $packageName, string $type, string $method, string $filename): self
    {
        return new static("$method: $type filename '$filename' is neither .php or .php.stub in package $packageName");
    }

    public static function duplicateNamespace(string $packageName, string $method, string $type, string $key): self
    {
        return new static("$method cannot use $type '$key' more than once in package $packageName");
    }

    public static function noEventListenerSpecified(string $packageName, string $method, string $class): self
    {
        return new static("$method requires a Listener class for Event '$class' in package $packageName");
    }

    public static function laravelFunctionalityNotYetImplemented(string $packageName, string $method, string $version): self
    {
        return new static("$method requires functionality first implemented in Laravel v$version in package $packageName");
    }

    public static function emptyParameter(string $packageName, string $method, string $param): self
    {
        return new static("$method requires parameter '$param' to be specified in package $packageName");
    }
}
