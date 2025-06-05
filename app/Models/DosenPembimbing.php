<?php

namespace App\Models;

use App\Models\KontrakMagang;
use App\Models\UserBase;

class DosenPembimbing extends UserBase
{
    protected $table = 'dosen_pembimbing';

    protected $fillable = [
        'nama',
        'nidn',
        'password',
        'jenis_kelamin',
        'foto',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'jenis_kelamin' => 'string',
    ];

    public function getRoleName(): string
    {
        return 'dosen';
    }

    public function kontrakMagang()
    {
        return $this->hasMany(KontrakMagang::class, 'dosen_id');
    }
}
