<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasProviders
{
    private static string $publishableProviderDefaultPath = '../resources/stubs';

    public array $publishableProviderNames = [];
    protected ?string $publishableProviderPath = null;

    public function publishesServiceProvider(string $providerName, string $path = null): self
    {
        $this->publishableProviderNames[] = $providerName;

        $this->publishableProviderPath = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$publishableProviderDefaultPath);

        return $this;
    }

    public function publishableProviderPath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->publishableProviderPath, $directory);
    }
}
