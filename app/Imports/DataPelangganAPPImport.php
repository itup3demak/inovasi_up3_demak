<?php

namespace App\Imports;

use App\Models\PelangganAPPModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Session;

class DataPelangganAPPImport implements ToModel, WithStartRow, WithMultipleSheets
{
    use Importable;
    private $importedCount = 0;
    private $updatedCount = 0;
    public function sheets(): array
    {
        return [
            'Worksheet' => $this,
        ];
    }

    public function model(array $row)
    {
        $data = $this->getData($row);
        $existingData = PelangganAPPModel::updateOrCreate(
            ['id_pelanggan' => $data['id_pelanggan']],
            $data
        );

        if ($existingData->wasRecentlyCreated) {
            $this->importedCount++;
        } else {
            $this->updatedCount++;
        }

        return null;
    }

    /**
     * Ambil data dari baris excel untuk disimpan ke model.
     */
    private function getData(array $row)
    {
        return [
            'tanggal_pasang' => $row[0] ?? '',
            'id_pelanggan' => $row[1] ?? '',
            'nama_pelanggan' => $row[2] ?? '',
            'tarif' => $row[3] ?? '',
            'daya' => $row[4] ?? '',
            'alamat' => $row[5] ?? '',
            'latitude' => $row[6] ?? '',
            'longitude' => $row[7] ?? '',
            'jenis_meter' => $row[8] ?? '',
            'nomor_meter' => $row[9] ?? '',
            'merk_meter' => $row[10] ?? '',
            'tahun_meter' => $row[11] ?? '',
            'merk_mcb' => $row[12] ?? '',
            'ukuran_mcb' => $row[13] ?? '',
            'no_segel' => $row[14] ?? '',
            'no_gardu' => $row[15] ?? '',
            'sr_deret' => $row[16] ?? '',
            'nama_petugas' => $row[17] ?? '',
            'catatan' => $row[18] ?? '',
        ];
    }
    public function startRow(): int
    {
        return 6;
    }
    public function __destruct()
    {
        Session::flash('success_import_kelengkapan_data_aset', "{$this->importedCount} data baru ditambahkan");
    }
}
