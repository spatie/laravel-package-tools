<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasViewSharedData
{
    public array $sharedViewData = [];

    public function sharesDataWithAllViews(string $name, $value): self
    {
        $this->verifyUniqueKey(__FUNCTION__, 'name', $this->sharedViewData, $name);
        $this->sharedViewData[$name] = $value;

        return $this;
    }

    public function sharesDataWithAllViewsByArray(array $sharedData): self
    {
        foreach ($sharedData as $name => $value) {
            $this->sharesDataWithAllViews($name, $value);
        }

        return $this;
    }
}
