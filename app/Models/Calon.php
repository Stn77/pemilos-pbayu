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
        'misi',
        'jumlah_suara'
    ];

    public function votings()
    {
        return $this->hasMany(Voting::class);
    }
}
