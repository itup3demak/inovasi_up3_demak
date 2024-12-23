<?php

namespace App\Imports;

use App\Models\DataPohonModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataPohonImport implements ToModel, WithStartRow, WithMultipleSheets
{
    use Importable;
    private $importedCount = 0;
    private $updatedCount = 0;
    public function sheets(): array
    {
        return [
            'UP3' => $this,
        ];
    }

    public function model(array $row)
    {
        $data = $this->getData($row);
        $existingData = DataPohonModel::updateOrCreate(
            ['tiang_section' => $data['tiang_section']],
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
            'tiang_section' => $row[3] ?? '',
            'latitude' => $row[4] ?? '',
            'longitude' => $row[5] ?? '',
            'rayon' => $row[6] ?? '',
            'perlu_rabas' => $row[7] ?? '',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }
    public function __destruct()
    {
        Session::flash('success_import_data_pohon', "{$this->importedCount} data baru ditambahkan");
    }
}
