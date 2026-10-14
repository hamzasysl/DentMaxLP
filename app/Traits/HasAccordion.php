<?php

namespace App\Traits;

trait HasAccordion
{
    public int $openIndex = 0;

    public function setOpenIndex(int $openIndex = 0): void
    {
        $this->openIndex = $openIndex;
    }

    public function toggle(int $index): void
    {
        $this->openIndex = ($this->openIndex === $index) ? -1 : $index;
    }
}
