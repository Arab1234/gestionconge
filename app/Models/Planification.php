<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planification extends Model
{
    use HasFactory;

    protected $fillable = [
        'Année', 'DateDébut1', 'DateFin1', 'DateDébut2', 'DateFin2',
        'DateDébut3', 'DateFin3', 'VCS', 'VRH', 'IdUser',
    ];
}
