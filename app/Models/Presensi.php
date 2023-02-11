<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik', 'presensi_date', 'clock_in', 'clock_out', 'photo_in', 'photo_out', 'location_in', 'location_out'
    ];

    protected $table = "presensi";
}
