<?php

namespace App\Support;

use Illuminate\Support\Facades\Schema;

class FeatureTableGuard
{
    /**
     * @param  array<int, string>  $tables
     */
    public static function hasTables(array $tables): bool
    {
        foreach ($tables as $table) {
            if (! Schema::hasTable($table)) {
                return false;
            }
        }

        return true;
    }
}
