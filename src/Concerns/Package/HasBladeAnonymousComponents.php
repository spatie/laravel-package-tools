<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait HasBladeAnonymousComponents
{
    public static string $bladeAnonymousComponentsDefaultPrefix = "[null]";
    private static string $bladeAnonymousComponentsDefaultPath = "../resources/views/components";

    public array $bladeLoadsAnonymousComponentsPaths = [];

    public function loadsBladeAnonymousComponentsByPath(?string $prefix = "[shortname]", ?string $path = null): self
    {
        if (version_compare(App::version(), '9.44.0') < 0) {
            throw InvalidPackage::laravelFunctionalityNotYetImplemented(
                $this->name,
                __FUNCTION__,
                '9.44.0'
            );
        }

        if ($prefix === "[shortname]") {
            $prefix = $this->shortName();
        } else {
            $prefix ??= static::$bladeAnonymousComponentsDefaultPrefix;
        }
        $this->verifyUniqueKey(__FUNCTION__, 'prefix', $this->bladeLoadsAnonymousComponentsPaths, $prefix);
        $this->bladeLoadsAnonymousComponentsPaths[$prefix] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$bladeAnonymousComponentsDefaultPath);

        return $this;
    }
}
