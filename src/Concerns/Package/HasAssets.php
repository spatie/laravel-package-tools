<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasAssets
{
    public bool $hasAssets = false;
    protected ?string $assetsPath = '/../resources/dist';

    public function hasAssets(): self
    {
        $this->hasAssets = true;

        $this->assetsPath = $this->verifyDirOrNull($this->assetsPath);

        return $this;
    }

    public function assetsPath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->assetsPath, $directory);
    }

    public function setAssetsPath(string $path): self
    {
        $this->assetsPath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }
}
