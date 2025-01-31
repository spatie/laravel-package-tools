<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasViews
{
    public bool $hasViews = false;
    protected ?string $viewNamespace = null;
    protected string $viewsPath = '/../resources/views';

    public function hasViews(?string $namespace = null): self
    {
        $this->hasViews = true;
        $this->viewNamespace = $namespace;

        return $this;
    }

    public function viewNamespace(): string
    {
        return $this->viewNamespace ?? $this->shortName();
    }

    public function viewsPath(?string $directory = null): string
    {
        return $this->buildDirectory($this->viewsPath, $directory);
    }

    public function setViewsPath(string $path): self
    {
        $this->verifyDir($this->buildDirectory($path));
        $this->viewsPath = $path;

        return $this;
    }
}
