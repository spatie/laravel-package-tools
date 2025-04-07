<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasTranslations
{
    private static string $translationsDefaultPath = '../resources/lang';

    public array $translationLoadsPaths = [];
    public array $translationPublishesPaths = [];

    public function loadsTranslationsByPath(?string $namespace = null, ?string $path = null): self
    {
        $namespace = $namespace ?? $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->translationLoadsPaths, $namespace);

        $this->translationLoadsPaths[$namespace] =
            $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$translationsDefaultPath);

        return $this;
    }

    public function publishesTranslationsByPath(?string $namespace = null, ?string $path = null): self
    {
        $namespace = $namespace ?? $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->translationPublishesPaths, $namespace);

        $this->translationPublishesPaths[$namespace] =
            $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$translationsDefaultPath);

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasTranslations(?string $namespace = null, ?string $path = null): self
    {
        return $this
            ->loadsTranslationsByPath($namespace, $path)
            ->publishesTranslationsByPath($namespace, $path);
    }
}
