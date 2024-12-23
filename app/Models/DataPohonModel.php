<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPohonModel extends Model
{
    use HasFactory;
    protected $table = 'data_pohon';
    protected $primaryKey = 'id';
    protected $fillable = ['tiang_section', 'perlu_rabas', 'latitude', 'longitude', 'rayon'];
}
