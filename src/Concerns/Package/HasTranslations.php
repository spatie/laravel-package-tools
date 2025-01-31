<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasTranslations
{
    public bool $hasTranslations = false;
    protected string $translationsPath = '/../resources/lang';

    public function hasTranslations(): self
    {
        $this->hasTranslations = true;

        return $this;
    }

    public function translationsPath(?string $directory = null): string
    {
        return $this->buildDirectory($this->translationsPath, $directory);
    }

    public function setTranslationsPath(string $path): self
    {
        $this->verifyDir($this->buildDirectory($path));
        $this->translationsPath = $path;

        return $this;
    }
}
