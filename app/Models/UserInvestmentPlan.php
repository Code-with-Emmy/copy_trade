<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInvestmentPlan extends Model
{
    use HasFactory;
    protected $table = 'user_investment_plans';
    protected $fillable = ['user', 'plan', 'amount', 'active', 'activated_at', 'last_growth', 'expire_date'];
}
