<?php

namespace App\Models\Concerns;

trait HasLocalizedAttributes
{
    public function localized(string $field, ?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();

        $primaryField = "{$field}_{$locale}";
        $fallbackFields = [
            "{$field}_" . config('app.fallback_locale', 'en'),
            "{$field}_ar",
            "{$field}_en",
            "{$field}_fr",
            $field,
        ];

        $candidates = array_unique([$primaryField, ...$fallbackFields]);

        foreach ($candidates as $candidate) {
            $value = $this->getAttribute($candidate);

            if (is_string($value) && trim($value) !== '') {
                return $value;
            }
        }

        return null;
    }
}
