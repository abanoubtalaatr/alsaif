<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PasswordResetOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'is_used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    /**
     * Check if OTP is expired
     */
    public function isExpired(): bool
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    /**
     * Check if OTP is valid (not used and not expired)
     */
    public function isValid(): bool
    {
        return !$this->is_used && !$this->isExpired();
    }

    /**
     * Mark OTP as used
     */
    public function markAsUsed(): void
    {
        $this->update(['is_used' => true]);
    }

    /**
     * Generate a new OTP
     */
    public static function generateOtp(): string
    {
        return str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new OTP for email
     */
    public static function createForEmail(string $email): self
    {
        // Delete any existing OTPs for this email
        static::where('email', $email)->delete();

        return static::create([
            'email' => $email,
            'otp' => static::generateOtp(),
            'expires_at' => Carbon::now()->addMinutes(10), // OTP expires in 10 minutes
        ]);
    }
}
