<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasAssets
{
    private static string $assetsDefaultPath = '/../resources/dist';

    public bool $hasAssets = false;
    public ?string $assetsPath = null;

    public function hasAssets(?string $path = null): self
    {
        $this->hasAssets = true;

        $this->assetsPath = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$assetsDefaultPath);

        return $this;
    }

    public function assetsPath(?string $directory = null): string
    {
        return $this->buildDirectory($this->assetsPath, $directory);
    }
}
