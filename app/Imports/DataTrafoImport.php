<?php

namespace App\Imports;

use App\Models\DataTrafoModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataTrafoImport implements ToModel, WithStartRow, WithMultipleSheets
{
    use Importable;
    private $importedCount = 0;
    private $updatedCount = 0;
    public function sheets(): array
    {
        return [
            '25 kVA (80%)' => $this,
            '50kVA (- 40%)' => $this,
            '50kVA (80%)' => $this,
        ];
    }

    public function model(array $row)
    {
        $data = $this->getData($row);
        $existingData = DataTrafoModel::updateOrCreate(
            ['nomor_tiang' => $data['nomor_tiang']],
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
            'rayon' => $row[1] ?? '',
            'nomor_tiang' => $row[3] ?? '',
            'nomor_gardu' => $row[4] ?? '',
            'latitude' => $row[5] ?? '',
            'longitude' => $row[6] ?? '',
            'x1' => $row[14] ?? '',
            'x2' => $row[15] ?? '',
            'n' => $row[16] ?? '',
            'perhitungan_beban' => $row[67] ?? '',
            'klasifikasi_beban' => $row[68] ?? '',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }
    public function __destruct()
    {
        Session::flash('success_import_data_trafo2', "{$this->importedCount} data baru ditambahkan");
    }
}
