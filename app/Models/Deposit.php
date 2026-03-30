<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Deposit extends Model
{
    use HasFactory;

    protected static ?array $depositColumns = null;

    protected function depositSupportsColumn(string $column): bool
    {
        if (self::$depositColumns === null) {
            self::$depositColumns = Schema::hasTable($this->getTable())
                ? Schema::getColumnListing($this->getTable())
                : [];
        }

        return in_array($column, self::$depositColumns, true);
    }

    public function setAttribute($key, $value)
    {
        if ($key === 'txn_id' && !$this->depositSupportsColumn('txn_id')) {
            return $this;
        }

        if ($key === 'signals' && !$this->depositSupportsColumn('signals')) {
            $normalized = is_string($value) ? trim($value) : $value;

            if (
                $this->depositSupportsColumn('plan')
                && filled($normalized)
                && !in_array((string) $normalized, ['0', 'BT'], true)
            ) {
                return parent::setAttribute('plan', $normalized);
            }

            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    public function getSignalsAttribute($value)
    {
        if ($this->depositSupportsColumn('signals')) {
            return $value;
        }

        if (($this->attributes['payment_mode'] ?? null) === 'Express Deposit') {
            return null;
        }

        $plan = $this->attributes['plan'] ?? null;

        if (blank($plan) || in_array((string) $plan, ['0', 'BT'], true) || is_numeric($plan)) {
            return null;
        }

        return $plan;
    }

    public function duser(){
    	return $this->belongsTo('App\Models\User', 'user');
    }

    public function dplan(){
    	return $this->belongsTo('App\Models\Plans', 'plan');
    }
}
