<?php

namespace App\Models;

// TAMBAHKAN DUA BARIS INI
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
// -----------------------------

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// TAMBAHKAN 'implements FilamentUser'
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    // ... (kode $fillable, $hidden, $casts Anda yang sudah ada, biarkan)

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    // TAMBAHKAN FUNGSI INI
    public function canAccessPanel(Panel $panel): bool
    {
        // Untuk sekarang, kita izinkan semua user yang sudah login untuk mengakses panel.
        return true;
    }
}
