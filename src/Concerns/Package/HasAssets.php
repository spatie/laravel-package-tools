<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasAssets
{
    private static string $assetsDefaultPath = '../resources/dist';

    public array $assetsPublishesPaths = [];

    public function publishesAssetsByPath(?string $namespace = null, ?string $path = null): self
    {
        $namespace ??= $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->assetsPublishesPaths, $namespace);

        $this->assetsPublishesPaths[$namespace] =
            $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$assetsDefaultPath);

        return $this;
    }

    public function hasAssets(?string $namespace = null, ?string $path = null): self
    {
        return $this->publishesAssetsByPath($namespace, $path);
    }
}
