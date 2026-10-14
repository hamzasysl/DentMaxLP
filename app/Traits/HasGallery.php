<?php

namespace App\Traits;

trait HasGallery
{
    public array $cases = [];

    /**
     * Gallery datasını LP component’ten alır
     */
    public function initGallery(): void
    {
        $this->cases = $this->galleryData();
    }

    /**
     * Bunu kullanan component doldurmak ZORUNDA
     */
    abstract protected function galleryData(): array;
}
