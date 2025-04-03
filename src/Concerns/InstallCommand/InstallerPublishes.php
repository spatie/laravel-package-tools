<?php

namespace Spatie\LaravelPackageTools\Concerns\InstallCommand;

trait InstallerPublishes
{
    public array $publishes = [];

    public function publish(string ...$tag): self
    {
        $this->publishes = array_unique(array_merge(
            $this->publishes,
            $tag
        ));

        return $this;
    }

    public function publishAssets(): self
    {
        return $this->publish('assets');
    }

    public function publishBladeComponents(): self
    {
        return $this->publish('components');
    }

    public function publishConfigFile(): self
    {
        return $this->publishConfigFiles();
    }

    public function publishConfigFiles(): self
    {
        return $this->publish('config');
    }

    public function publishInertiaComponents(): self
    {
        return $this->publish('inertia-components');
    }

    public function publishLivewireComponents(): self
    {
        return $this->publish('livewire-components');
    }

    public function publishMigrations(): self
    {
        return $this->publish('migrations');
    }

    public function publishServiceProviders(): self
    {
        return $this->publish('provider');
    }

    public function publishRoutes(): self
    {
        return $this->publish('routes');
    }

    public function publishTranslations(): self
    {
        return $this->publish('translations');
    }

    public function publishViews(): self
    {
        return $this->publish('views');
    }

    protected function processPublishes(): self
    {
        foreach ($this->publishes as $tag) {
            $name = str_replace('-', ' ', $tag);
            $this->comment("Publishing {$name}...");

            $this->callSilently("vendor:publish", [
                '--tag' => "{$this->package->shortName()}-{$tag}",
            ]);
        }

        return $this;
    }
}
