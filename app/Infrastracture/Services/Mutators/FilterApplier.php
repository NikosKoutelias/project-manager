<?php

namespace App\Infrastracture\Services\Mutators;

use App\Infrastracture\Services\Interfaces\Sanitizer;

readonly class FilterApplier
{

    public function __construct(private Sanitizer $sanitizer, private string $text)
    {}

    public function applyFilters(): string
    {
        return $this->sanitizer->formatText($this->text);
    }
}
