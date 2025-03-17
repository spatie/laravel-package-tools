<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasTranslations
{
    private const translationsDefaultPath = '../resources/lang';

    public array $translationPaths = [];

    public function hasTranslations(?string $namespace = null, ?string $path = null): self
    {
        $namespace = $namespace ?? $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->translationPaths, $namespace);

        $this->translationPaths[$namespace] =
            $this->verifyRelativeDir(__FUNCTION__, $path ?? static::translationsDefaultPath);

        return $this;
    }
}
