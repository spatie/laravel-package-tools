<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

class PackageServiceProviderConcreteTestCase extends PackageServiceProviderTestCase
{

    private static ?PackageServiceProviderConcreteTestCase $instance = null;
    public Package $instancePackage;
    private string $utilityField;

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

    public static function setUtilityField(string $value): void
    {
        static::getInstance()->utilityField = $value;
    }

    public static function getUtilityField(): string
    {
        return static::getInstance()->utilityField;
    }

    public function configurePackage(Package $package): void
    {
        $instancePackageProps = get_object_vars(static::getInstance()->instancePackage);
        foreach ($instancePackageProps as $key => $value) {
                $package->{$key} = $value;
        }

    }

    /*
    * If we leave the published config file in,
    * all subsequent tests will fail
    */
    public function restoreAppConfigFile(): void
    {
        $newContent = str_replace(
            'App\Providers\MyPackageServiceProvider::class,',
            '',
            file_get_contents(base_path('config/app.php'))
        );

        file_put_contents(base_path('config/app.php'), $newContent);
    }


}
