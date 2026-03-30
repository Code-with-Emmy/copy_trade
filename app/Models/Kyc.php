<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

class Kyc extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'id_type',
        'frontimg',
        'backimg',
        'face_img',
        'status',
        'ssn',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function hasSchemaColumn(string $column): bool
    {
        return Schema::hasColumn((new static())->getTable(), $column);
    }

    public function getPhoneNumberAttribute(): ?string
    {
        return $this->attributes['phone_number'] ?? $this->attributes['phone'] ?? null;
    }

    public function getDocumentTypeAttribute(): ?string
    {
        return $this->attributes['document_type'] ?? $this->attributes['id_type'] ?? null;
    }

    public function getSocialMediaAttribute(): string
    {
        return (string) ($this->attributes['social_media'] ?? 'Not provided');
    }
}
