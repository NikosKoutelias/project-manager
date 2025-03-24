<?php

namespace App\Infrastracture\Services;

use App\Infrastracture\Services\Interfaces\Sanitizer;

/**
 * implement the basic decoration infrastructure
 */
class TextFormat implements Sanitizer
{
    protected Sanitizer $sanitizer;

    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function formatText(string $text): string
    {
        return $this->sanitizer->formatText($text);
    }
}
