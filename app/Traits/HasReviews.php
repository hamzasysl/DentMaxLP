<?php

namespace App\Traits;

trait HasReviews
{
    public array $reviews = [];

    public function setReviews(array $reviews): void
    {
        $this->reviews = array_values(array_map(function ($r) {
            return [
                'name'   => $r['name']   ?? '',
                'rating' => (float) ($r['rating'] ?? 5),
                'text'   => $r['text']   ?? '',
                'date'   => $r['date']   ?? null,
                'avatar' => $r['avatar'] ?? null,
            ];
        }, $reviews));
    }
}
