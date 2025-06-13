<?php

namespace App\Models;

use App\Models\BaseKriteriaModel;

class KriteriaBidangIndustri extends BaseKriteriaModel
{
    protected $table = 'kriteria_bidang_industri';

    protected $fillable = [
        'bidang_industri_id',
        'mahasiswa_id',
        'rank',
        'bobot'
    ];

    public function bidangIndustri() {
        return $this->belongsTo(BidangIndustri::class);
    }
}
