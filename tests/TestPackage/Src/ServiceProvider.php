<?php


namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src;

use Closure;
use Exception;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ServiceProvider extends PackageServiceProvider
{
    public static ?Exception $thrownException = null;
    public static ?Closure $configurePackageUsing = null;

    public function configurePackage(Package $package): void
    {
        $configClosure = self::$configurePackageUsing ?? function (Package $package) {
        };

        ($configClosure)($package);
    }

    /**
     * Handle exceptions in PackageServiceProvider generated during register or boot
     *
     * The first exception is stored so that the Pest testcase can replay it during test initiation
     **/
    public function register(): self
    {
        try {
            return parent::register();
        } catch (Exception $e) {
            self::$thrownException = $e;
        }

        return $this;
    }

    public function boot(): self
    {
        // Do not run boot if there was an exception in register
        if (ServiceProvider::$thrownException) {
            return $this;
        }

        try {
            return parent::boot();
        } catch (Exception $e) {
            self::$thrownException = $e;
        }

        return $this;
    }
}