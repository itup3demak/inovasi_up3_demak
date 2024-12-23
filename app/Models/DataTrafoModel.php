<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTrafoModel extends Model
{
    use HasFactory;
    protected $table = 'data_trafo2';
    protected $primaryKey = 'id';
    protected $fillable = ['rayon','nomor_tiang', 'nomor_gardu', 'latitude', 'longitude', 'x1', 'x2', 'n', 'perhitungan_beban', 'klasifikasi_beban'];

}
