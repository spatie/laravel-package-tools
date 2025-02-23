<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasLivewire
{
    public bool $hasLivewire = false;
    protected ?string $livewireNamespace = null;
    protected ?string $livewireComponentsPath = '/Livewire';
    protected ?string $livewireViewsPath = '/../resources/views/livewire';

    public function hasLivewire(?string $namespace = null): self
    {
        $this->hasLivewire = true;
        $this->livewireNamespace = $namespace;

        $this->livewireComponentsPath = $this->verifyDirOrNull($this->livewireComponentsPath);
        $this->livewireViewsPath = $this->verifyDirOrNull($this->livewireViewsPath);

        return $this;
    }

    public function livewireNamespace(): string
    {
        return $this->livewireNamespace ?? $this->shortName();
    }

    public function livewireComponentsPath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->livewireComponentsPath, $directory);
    }

    public function setLivewireComponentsPath(string $path): self
    {
        $this->livewireComponentsPath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }

    public function livewireViewsPath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->livewireViewsPath, $directory);
    }

    public function setLivewireViewsPath(string $path): self
    {
        $this->livewireViewsPath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }
}
