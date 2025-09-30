<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pemilih extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nisn',
        'nama',
        'kelas',
        'password',
        'sudah_memilih'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'sudah_memilih' => 'boolean',
        ];
    }

    public function voting()
    {
        return $this->hasOne(Voting::class);
    }

   public function hasVoted()
    {
        return $this->sudah_memilih;
    }

    // Atau jika ingin tetap menggunakan nama yang sama, tambahkan method ini:
    public function sudahMemilih()
    {
        return $this->sudah_memilih;
    }
}
