<?php

use App\Infrastracture\Services\Handlers\TextInput;
use App\Infrastracture\Services\Mutators\FilterApplier;
use App\Infrastracture\Services\PlainTextFilter;
use App\Infrastracture\Services\SanitzeTextFilter;

if (! function_exists('apply_filters')) {
    function apply_filters($filters, array $data): array
    {
        $sanitizedText = [];

        foreach ($filters as $filter) {
            $text = new TextInput();
            $textFilter = new PlainTextFilter($text);
            $sanitizeFilter = new SanitzeTextFilter($text);

            if (!isset($data[$filter])) continue;

            $filteredText = (new FilterApplier($textFilter, $data[$filter]))->applyFilters();
            $sanitizedText[$filter] = (new FilterApplier($sanitizeFilter, $filteredText))->applyFilters();
        }

        return $sanitizedText;
    }
}
