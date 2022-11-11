<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

class PackageServiceProviderConcreteTestCase extends PackageServiceProviderTestCase
{

    private static ?PackageServiceProviderConcreteTestCase $instance = null;
    public Package $instancePackage;

    public static function getInstance(): PackageServiceProviderConcreteTestCase{
        if (!static::$instance) {
            static::$instance = new self();
            static::$instance->instancePackage = new Package();
        }
        return static::$instance;
    }


    private function setUpPackage(Package $package): void
    {
        $this->instancePackage = $package;
    }

    public static function package(Package $package): void
    {
        static::getInstance()->setUpPackage($package);
    }

    public function configurePackage(Package $package): void
    {
        $instancePackageProps = get_object_vars(static::getInstance()->instancePackage);
        foreach ($instancePackageProps as $key => $value) {
                $package->{$key} = $value;
        }

    }



}
