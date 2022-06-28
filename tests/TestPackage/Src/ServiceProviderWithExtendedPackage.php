<?php


namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src;

use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;

class ServiceProviderWithExtendedPackage extends ServiceProvider
{
    protected function getInitializedPackage(): Package
    {
        return $this->getPackageExtension();
    }

    protected function getPackageExtension(): Package
    {
        return new class extends Package {
            public function name(string $name): Package
            {
                $newName = Str::start($name, 'foo-');
                return parent::name($newName);
            }

            public function shortName(): string
            {
                return Str::after(parent::shortName(), 'foo-');
            }
        };
    }
}
