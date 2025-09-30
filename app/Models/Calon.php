<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calon extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_calon',
        'foto',
        'visi',
        'jumlah_suara'
    ];

    public function votings()
    {
        return $this->hasMany(Voting::class);
    }
    public function misi()
    {
        return $this->hasMany(Misi::class);
    }
}
