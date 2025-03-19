<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners;

use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Events\TestEvent;

class TestListener
{
    public function handle(TestEvent $event): void
    {
    }

    public function respond(TestEvent $event): void
    {
    }

    public function handleWildcard(string $name, ...$payload): void
    {
    }

    public function respondWildcard(string $name, ...$payload): void
    {
    }
}
