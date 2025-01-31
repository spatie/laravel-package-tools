<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasLivewire
{
    public bool $hasLivewire = false;
    protected ?string $livewireNamespace = null;
    protected string $livewireComponentsPath = '/Livewire';
    protected string $livewireViewsPath = '/../resources/views/livewire';

    public function hasLivewire(?string $namespace = null): self
    {
        $this->hasLivewire = true;
        $this->livewireNamespace = $namespace;

        return $this;
    }

    public function livewireNamespace(): string
    {
        return $this->livewireNamespace ?? $this->shortName();
    }

    public function livewireComponentsPath(?string $directory = null): string
    {
        return $this->buildDirectory($this->livewireComponentsPath, $directory);
    }

    public function setLivewireComponentsPath(string $path): self
    {
        $this->verifyDir($this->buildDirectory($path));
        $this->livewireComponentsPath = $path;

        return $this;
    }

    public function livewireViewsPath(?string $directory = null): string
    {
        return $this->buildDirectory($this->livewireViewsPath, $directory);
    }

    public function setLivewireViewsPath(string $path): self
    {
        $this->verifyDir($this->buildDirectory($path));
        $this->livewireViewsPath = $path;

        return $this;
    }

}
