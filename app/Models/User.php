<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    /**
     * Check if user can donate food
     */
    public function canDonate(): bool
    {
        return in_array($this->role, ['donor', 'both']);
    }

    /**
     * Check if user can receive food
     */
    public function canReceive(): bool
    {
        return in_array($this->role, ['recipient', 'both']);
    }

    /**
     * Get user role display name
     */
    public function getRoleDisplayAttribute(): string
    {
        return match ($this->role) {
            'donor' => 'Food Donor',
            'recipient' => 'Food Recipient',
            'both' => 'Donor & Recipient',
            default => 'Unknown'
        };
    }
}
