<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calon_id',
        'waktu_voting'
    ];

    protected $casts = [
        'waktu_voting' => 'datetime',
    ];

    public function pemilih()
    {
        return $this->belongsTo(User::class);
    }

    public function calon()
    {
        return $this->belongsTo(Calon::class);
    }
}
