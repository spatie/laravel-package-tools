<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasTranslations
{
    public bool $hasTranslations = false;
    protected ?string $translationsPath = '/../resources/lang';

    public function hasTranslations(): self
    {
        $this->hasTranslations = true;
        
        $this->translationsPath = $this->verifyDirOrNull($this->translationsPath);

        return $this;
    }

    public function translationsPath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->translationsPath, $directory);
    }

    public function setTranslationsPath(string $path): self
    {
        $this->translationsPath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }
}
