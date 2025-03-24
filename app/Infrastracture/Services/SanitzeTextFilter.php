<?php

namespace App\Infrastracture\Services;

class SanitzeTextFilter extends TextFormat
{
    public function formatText(string $text): string
    {
        $text = parent::formatText($text);

        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}
