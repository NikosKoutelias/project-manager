<?php

namespace App\Infrastracture\Services\Handlers;

use App\Infrastracture\Services\Interfaces\Sanitizer;

class TextInput implements Sanitizer
{
    public function formatText(string $text): string
    {
        return $text;
    }
}
