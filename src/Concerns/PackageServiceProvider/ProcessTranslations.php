<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Illuminate\Support\Facades\File;

trait ProcessTranslations
{
    protected function bootPackageTranslations(): self
    {
        if (! $this->package->translationPaths) {
            return $this;
        }


        foreach ($this->package->translationPaths as $namespace => $translationPath) {

            /**
             * Same language files cannot be loaded simultaneously from two locations
             * i.e. original files from the package or published copies
             * So we need to test to see if published files exist and if so load them
             * and only load the originals if not
             **/
            $langPath = lang_path("vendor/{$namespace}");
            if (is_dir($langPath) && File::allFiles($langPath . '/*')) {
                $this->loadTranslationsFrom(
                    $langPath,
                    $namespace
                );
                $this->loadJsonTranslationsFrom($langPath);
            } else {
                $translationPath = $this->package->basePath($translationPath);
                $this->loadTranslationsFrom(
                    $translationPath,
                    $namespace
                );
                $this->loadJsonTranslationsFrom($translationPath);
            }
        }

        if (! $this->app->runningInConsole()) {
            return $this;
        }

        $tag = "{$this->package->shortName()}-translations";
        foreach ($this->package->translationPaths as $namespace => $translationPath) {
            $translationPath = $this->package->basePath($translationPath);
            $langPath = lang_path("vendor/{$namespace}");
            $this->publishes(
                [$translationPath => $langPath],
                $tag
            );
        }

        return $this;
    }
}
