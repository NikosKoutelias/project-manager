<?php

namespace App\Infrastracture\Services\Interfaces;

/**
 * Interface declares a filtering method that must be implemented
 * by all concrete components.
 */
interface Sanitizer
{
    public function formatText(string $text): string;
}
