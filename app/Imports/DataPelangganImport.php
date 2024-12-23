<?php

namespace App\Imports;

use App\Models\DataPelangganModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Session;

class DataPelangganImport implements ToModel, WithStartRow
{
    use Importable;

    private $importedCount = 0;
    private $updatedCount = 0;

    public function sheets(): array
    {
        return [
            'Pelanggan' => $this, // Sheet "Pelanggan" akan diproses
        ];
    }

    public function model(array $row)
    {
        $data = $this->getData($row);
        $existingData = DataPelangganModel::updateOrCreate(
            ['idpel' => $data['idpel']],
            $data
        );

        if ($existingData->wasRecentlyCreated) {
            $this->importedCount++;
        } else {
            $this->updatedCount++;
        }

        return null;
    }

    private function getData(array $row)
    {
        return [
            'idpel' => $row[0] ?? '',
            'nama' => $row[1] ?? '',
            'nama_stakeholder' => $row[2] ?? '',
            'jenis_stakeholder' => $row[3] ?? '',
            'nohp_stakeholder' => $row[4] ?? '',
            'namapic_lapangan' => $row[5] ?? '',
            'nohp_piclapangan' => $row[6] ?? '',
            'alamat' => $row[7] ?? '',
            'maps' => $row[8] ?? '',
            'latitude' => $row[9] ?? '',
            'longtitude' => $row[10] ?? '',
            'unitulp' => $row[11] ?? '',
            'tarif' => $row[12] ?? '',
            'daya' => $row[13] ?? '',
            'kogol' => $row[14] ?? '',
            'fakmkwh' => $row[15] ?? '',
            'rpbp' => $row[16] ?? '',
            'rpujl' => $row[17] ?? '',
            'nomor_kwh' => $row[18] ?? '',
            'penyulang' => $row[19] ?? '',
            'nama_section' => $row[20] ?? '',
            'tipe_kubikel' => $row[21] ?? '',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }

    public function __destruct()
    {
        // Kirim flash message setelah proses selesai
        Session::flash('success_import_pelanggan', "{$this->importedCount} data baru ditambahkan, {$this->updatedCount} data diperbarui.");
    }
}
