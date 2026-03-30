<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSignal extends Model
{
    use HasFactory;
    protected $table = 'user_signals';
    protected $fillable = ['user', 'signals', 'active'];
}
