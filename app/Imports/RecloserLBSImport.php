<?php

namespace App\Imports;

use App\Models\MitraModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RecloserLBSImport implements ToModel, WithStartRow, WithMultipleSheets
{
    use Importable;
    private $importedCount = 0;
    private $updatedCount = 0;

    public function sheets(): array
    {
        return [
            'LBS' => $this,
            'RECLOSER' => $this,
            'RISE POLE' => $this,
        ];
    }

    public function model(array $row)
    {
        $data = $this->getData($row);
        $existingData = MitraModel::updateOrCreate(
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
            'penyulang' => $row[0] ?? '',
            'jenis_keypoint' => $row[1] ?? '',
            'nomor_tiang' => $row[2] ?? '',
            'absw' => $row[2] ?? '',
            'status_keypoint' => $row[3] ?? '',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }
    public function __destruct()
    {
        Session::flash('success_import_keypoint', "{$this->importedCount} data baru ditambahkan");
    }
}
