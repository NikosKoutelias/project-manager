<?php

namespace App\Infrastracture\Services;

class PlainTextFilter extends TextFormat
{

    public function formatText(string $text): string
    {
       $text = parent::formatText($text);
       return strip_tags($text);
    }
}
