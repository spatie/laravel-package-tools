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

    public static function fileDoesNotExist(string $packageName, string $file): self
    {
        return new static("File '$file' does not exist in package $packageName");
    }

    public static function dirDoesNotExist(string $packageName, string $dir): self
    {
        return new static("Directory '$dir' does not exist in package $packageName");
    }
}
