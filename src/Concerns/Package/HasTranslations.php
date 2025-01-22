<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasTranslations
{
    public bool $hasTranslations = false;

    public function hasTranslations(): self
    {
        $this->hasTranslations = true;

        return $this;
    }
}
