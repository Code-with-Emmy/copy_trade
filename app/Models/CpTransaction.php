<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpTransaction extends Model
{
    use HasFactory;

    protected $table = 'cp_transactions';
    protected $guarded = [];
}
