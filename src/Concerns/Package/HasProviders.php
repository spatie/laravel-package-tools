<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasProviders
{
    public array $publishableProviderNames = [];
    protected ?string $publishableProviderPath = '/../resources/stubs';

    public function publishesServiceProvider(string $providerName): self
    {
        $this->publishableProviderNames[] = $providerName;

        $this->publishableProviderPath = $this->verifyDirOrNull($this->publishableProviderPath);

        return $this;
    }

    public function publishableProviderPath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->publishableProviderPath, $directory);
    }

    public function setPublishableProviderPath(string $path): self
    {
        $this->publishableProviderPath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }
}
