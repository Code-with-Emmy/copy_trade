<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TpTransaction extends Model
{
    use HasFactory;
    protected $table = 'tp_transactions';
    protected $fillable = ['user', 'plan', 'amount', 'type', 'leverage', 'user_plan_id'];
}
