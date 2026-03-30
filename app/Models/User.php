<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use App\Models\Settings;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * Send the email verification notification.
     *
     * @return void
     */

    public function sendEmailVerificationNotification()
    {
        $settings = Settings::where('id', 1)->first();

        if ($settings->enable_verification == 'true') {
            try {
                $this->notify(new VerifyEmail);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Email Verification Error in User Model: ' . $e->getMessage());
            }
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'l_name',
        'email',
        'phone',
        'country',
        'password',
        'ref_by',
        'status',
        'taxtype ',
        'taxamount ',
        'currency',
        'notify',
        'username',
        'email_verified_at',
        'account_bal',
        'wallet_balance_synced_at',
        'roi',
        'bonus',
        'ref_bonus',
        'referral_code',
        'investor_profile',
        'risk_score',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'wallet_balance_synced_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected static ?array $userColumns = null;

    public static function schemaColumns(): array
    {
        if (self::$userColumns === null) {
            self::$userColumns = Schema::hasTable((new static())->getTable())
                ? Schema::getColumnListing((new static())->getTable())
                : [];
        }

        return self::$userColumns;
    }

    public static function hasSchemaColumn(string $column): bool
    {
        return in_array($column, self::schemaColumns(), true);
    }

    public static function filterSchemaAttributes(array $attributes): array
    {
        $columns = self::schemaColumns();

        return array_filter(
            $attributes,
            fn ($value, $key) => in_array($key, $columns, true),
            ARRAY_FILTER_USE_BOTH
        );
    }


    public function dp()
    {
        return $this->hasMany(Deposit::class, 'user');
    }

    public function wd()
    {
        return $this->hasMany(Withdrawal::class, 'user');
    }

    public function tuser()
    {
        return $this->belongsTo(Admin::class, 'assign_to');
    }

    public function dplan()
    {
        return $this->belongsTo(Plans::class, 'plan');
    }

    public function plans()
    {
        return $this->hasMany(UserPlan::class, 'user', 'id');
    }

    public function copySubscriptions()
    {
        return $this->hasMany(CopySubscription::class, 'user', 'id');
    }

    public function watchlist()
    {
        return $this->hasMany(TraderWatchlist::class, 'user_id', 'id');
    }

    public function walletAccount()
    {
        return $this->hasOne(WalletAccount::class);
    }

    public function platformTransactions()
    {
        return $this->hasMany(PlatformTransaction::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_user_id');
    }

    public function uplans()
    {
        return $this->hasMany(Investment::class, 'user', 'id');
    }

    public static function search($search): \Illuminate\Database\Eloquent\Builder
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
    }
}
