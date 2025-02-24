<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use function Illuminate\Events\queueable;
use Illuminate\Support\Facades\Event;

trait ProcessEvents
{
    public function bootPackageEvents(): self
    {
        $this
            ->bootPackageEventsByClass()
            ->bootPackageEventsAnonymous()
            ->bootPackageEventsQueueable();

        return $this;
    }

    protected function bootPackageEventsByClass(): self
    {
        if (empty($this->package->eventsByClass)) {
            return $this;
        }

        foreach ($this->package->eventsByClass as $eventClass => $listener) {
            Event::listen($eventClass, $listener);
        }

        return $this;
    }

    protected function bootPackageEventsAnonymous(): self
    {
        if (empty($this->package->eventsAnonymous)) {
            return $this;
        }

        foreach ($this->package->eventsAnonymous as $listener) {
            Event::listen($listener);
        }

        return $this;
    }

    protected function bootPackageEventsQueueable(): self
    {
        if (empty($this->package->eventsQueueable)) {
            return $this;
        }

        foreach ($this->package->eventsQueueable as $listener) {
            Event::listen(queueable($listener));
        }

        return $this;
    }
}
