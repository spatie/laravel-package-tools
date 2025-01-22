<?php

namespace Spatie\LaravelPackageTools\Concerns\InstallCommand;

trait startWithEndWith
{
    public ?Closure $startWith = null;
    public ?Closure $endWith = null;

    public function startWith($callable): self
    {
        $this->startWith = $callable;

        return $this;
    }

    public function endWith($callable): self
    {
        $this->endWith = $callable;

        return $this;
    }

    protected function processStartWith(): void
    {
        if ($this->startWith) {
            ($this->startWith)($this);
        }
    }

    protected function processEndWith(): void
    {
        if ($this->endWith) {
            ($this->endWith)($this);
        }
    }
}
