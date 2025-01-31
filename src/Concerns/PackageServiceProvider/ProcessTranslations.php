<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessTranslations
{
    protected function bootPackageTranslations(): self
    {
        if (! $this->package->hasTranslations) {
            return $this;
        }

        $pkgLangPath = $this->package->translationsPath();
        $this->loadTranslationsFrom(
            $pkgLangPath,
            $this->package->shortName()
        );

        $this->loadJsonTranslationsFrom($pkgLangPath);
        $this->loadJsonTranslationsFrom(lang_path('vendor/' . $this->package->name));

        if (! $this->app->runningInConsole()) {
            return $this;
        }

        $this->publishes(
            [$pkgLangPath => lang_path('vendor/' . $this->package->shortName())],
            "{$this->package->shortName()}-translations"
        );

        return $this;
    }
}
