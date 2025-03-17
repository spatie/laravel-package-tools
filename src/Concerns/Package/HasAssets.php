<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasAssets
{
    private const assetsDefaultPath = '../resources/dist';

    public array $assetsPaths = [];

    public function hasAssets(?string $namespace = null, ?string $path = null): self
    {
        $namespace ??= $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->assetsPaths, $namespace);

        $this->assetsPaths[$namespace] =
            $this->verifyRelativeDir(__FUNCTION__, $path ?? static::assetsDefaultPath);

        return $this;
    }
}
