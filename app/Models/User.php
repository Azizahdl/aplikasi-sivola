<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'foto_profile',
        'status_akun',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $url = url(route('password.reset', [
            'token' => $token,
            'email' => $this->getEmailForPasswordReset(),
        ], false));

        $count = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

        Mail::send(
            'auth.reset-password-notification',
            ['url' => $url, 'count' => $count, 'notifiable' => $this],
            fn ($m) => $m->to($this->email)
                         ->subject('Reset Kata Sandi - ' . config('app.name'))
        );
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function isAktif(): bool
    {
        return $this->status_akun === 'aktif';
    }

    public function isNonaktif(): bool
    {
        return $this->status_akun === 'nonaktif';
    }

    public function isSuspend(): bool
    {
        return $this->status_akun === 'suspend';
    }
}