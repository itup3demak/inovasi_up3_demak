<?php

namespace App\Imports;

use App\Models\DataZoneModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataZoneImport implements ToModel, WithStartRow, WithMultipleSheets
{
    use Importable;
    private $importedCount = 0;
    private $updatedCount = 0;
    public function sheets(): array
    {
        return [
            'ZONE 8kms' => $this,
        ];
    }

    public function model(array $row)
    {
        $data = $this->getData($row);
        $existingData = DataZoneModel::updateOrCreate(
            ['keypoint' => $data['keypoint']],
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
            'feeder' => $row[4] ?? '',
            'keypoint' => $row[5] ?? '',
            'jarak' => $row[6] ?? '',
            'latitude' => $row[8] ?? '',
            'longitude' => $row[9] ?? '',
            'google_maps' => $row[10] ?? '',
        ];
    }
    public function startRow(): int
    {
        return 3;
    }
    public function __destruct()
    {
        Session::flash('success_import_keypoint', "{$this->importedCount} data baru ditambahkan");
    }
}
