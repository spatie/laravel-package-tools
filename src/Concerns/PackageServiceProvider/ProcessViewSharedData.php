<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Illuminate\Support\Facades\View;

trait ProcessViewSharedData
{
    protected function bootViewSharedData()
    {
        if (empty($this->package->sharedViewData)) {
            return;
        }

        foreach ($this->package->sharedViewData as $name => $value) {
            View::share($name, $value);
        }
    }
}
