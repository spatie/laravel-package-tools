<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasInertia
{
    public bool $hasInertiaComponents = false;
    protected ?string $inertiaNamespace = null;
    protected string $inertiaComponentsPath = '/../resources/js/Pages';

    public function hasInertiaComponents(?string $namespace = null): self
    {
        $this->hasInertiaComponents = true;
        $this->inertiaNamespace = $namespace;

        return $this;
    }

    public function inertiaNamespace(): string
    {
        return $this->inertiaNamespace ?? $this->shortName();
   }

    public function inertiaComponentsPath(?string $directory = null): string
    {
        return $this->buildDirectory($this->inertiaComponentsPath, $directory);
    }

    public function setInertiaComponentsPath(string $path): self
    {
        $this->verifyDir($this->buildDirectory($path));
        $this->inertiaComponentsPath = $path;

        return $this;
    }
}
