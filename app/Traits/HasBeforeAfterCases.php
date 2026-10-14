<?php

namespace App\Traits;

trait HasBeforeAfterCases
{
    public array $cases = [];

    public function setCases(array $cases): void
    {
        // İstersen burada normalize / validate de edebilirsin
        // image boşsa ele, caption yoksa boş string vs.
        $this->cases = array_values(array_map(function ($c) {
            return [
                'image' => $c['image'] ?? '',
                'caption' => $c['caption'] ?? '',
            ];
        }, $cases));
    }
}
