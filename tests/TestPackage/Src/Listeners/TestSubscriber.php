<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners;

use Illuminate\Events\Dispatcher;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Events\TestEvent;

class TestSubscriber
{
    /**
     * Handle user login events.
     */
    public function handleTestEvent(TestEvent $event): void {}

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $eventDispatcher)
    {
        return [TestEvent::class => 'handleTestEvent'];

        $eventDispatcher->listen(
            TestEvent::class,
            [static::class, 'handleTestEvent']
        );
     }
}