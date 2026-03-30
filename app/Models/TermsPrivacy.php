<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class TermsPrivacy extends Model
{
    use HasFactory;

    public static function current(): ?self
    {
        $instance = new static();

        if (!Schema::hasTable($instance->getTable())) {
            return null;
        }

        return static::query()->find(1);
    }
}
