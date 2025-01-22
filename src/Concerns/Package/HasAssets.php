<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasAssets
{
    public bool $hasAssets = false;

    public function hasAssets(): self
    {
        $this->hasAssets = true;

        return $this;
    }
}
