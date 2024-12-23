<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganAPPModel extends Model
{
    use HasFactory;
    protected $table = 'entri_pelanggan_app';
    protected $primaryKey = 'id';
    protected $fillable = ['tanggal_pasang','id_pelanggan', 'nama_pelanggan', 'tarif', 'daya', 'alamat', 'latitude', 'longitude', 'jenis_meter', 'merk_meter', 'tahun_meter', 'nomor_meter', 'merk_mcb', 'no_segel','no_gardu','sr_deret','catatan', 'nama_petugas'];
    public $timestamps = true;
}
