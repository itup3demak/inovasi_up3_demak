<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntriPadamModel extends Model
{
    use HasFactory;

    protected $table = 'entri_padam';
    protected $primaryKey = 'id';
    protected $fillable = ['penyulang', 'section', 'jam_padam', 'penyebab_padam', 'status'];
}
