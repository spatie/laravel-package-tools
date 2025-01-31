<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasProviders
{
    public array $publishableProviderNames = [];
    protected string $publishableProviderPath = '/../resources/stubs';

    public function publishesServiceProvider(string $providerName): self
    {
        $this->publishableProviderNames[] = $providerName;

        return $this;
    }

    public function publishableProviderPath(?string $directory = null): string
    {
        return $this->buildDirectory($this->publishableProviderPath, $directory);
    }

    public function setPublishableProviderPath(string $path): self
    {
        $this->verifyDir($this->buildDirectory($path));
        $this->publishableProviderPath = $path;

        return $this;
    }
}
