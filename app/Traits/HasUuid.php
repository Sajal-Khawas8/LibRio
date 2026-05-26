<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    public function initializeHasUuid(): void
    {
        if (empty($this->attributes['uuid'])) {
            $this->attributes['uuid'] = Str::uuid()->toString();
        }
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}