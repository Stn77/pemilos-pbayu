<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemilih_id',
        'calon_id',
        'waktu_voting'
    ];

    protected $casts = [
        'waktu_voting' => 'datetime',
    ];

    public function pemilih()
    {
        return $this->belongsTo(Pemilih::class);
    }

    public function calon()
    {
        return $this->belongsTo(Calon::class);
    }
}
