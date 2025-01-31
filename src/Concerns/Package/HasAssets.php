<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasAssets
{
    public bool $hasAssets = false;
    protected string $assetsPath = '/../resources/dist';

    public function hasAssets(): self
    {
        $this->hasAssets = true;

        return $this;
    }

    public function assetsPath(?string $directory = null): string
    {
        return $this->buildDirectory($this->assetsPath, $directory);
    }

    public function setAssetsPath(string $path): self
    {
        $this->verifyDir($this->buildDirectory($path));
        $this->assetsPath = $path;

        return $this;
    }
}
