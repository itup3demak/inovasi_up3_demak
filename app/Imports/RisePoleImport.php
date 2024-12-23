<?php

namespace App\Imports;

use App\Models\MitraModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RisePoleImport implements ToModel, WithStartRow
{
    use Importable;
    private $importedCount = 0;
    private $updatedCount = 0;

    public function model(array $row)
    {
        $existingData = MitraModel::where('absw', $row[2])->first();

        if ($existingData) {
            $existingData->update($this->getData($row));
            Session::flash('error_import_keypoint', 'data keypoint sudah ada');
        } else {
            if ($this->isDuplicate($row)) {
                Session::flash('error_import_keypoint', 'Data sudah ada. Namun jika ada data tambahan lainnya, maka dapat dicek');
            } else {
                MitraModel::create($this->getData($row));
                Session::flash('success_import_keypoint', 'file excel keypoint berhasil diimport');
            }
        }
        MitraModel::create($this->getData($row));
        Session::flash('success_import_keypoint', 'file excel keypoint berhasil diimport');

        return null;
    }

    private function getData(array $row)
    {
        return [
            'penyulang' => $row[0] ?? '',
            'jenis_keypoint' => $row[1] ?? '',
            'absw' => $row[2] ?? '',
            'status_keypoint' => $row[3] ?? '',
        ];
    }
    private function isDuplicate(array $data)
    {
        return MitraModel::where('absw', $data['2'])->exists();
    }
    public function sheets(): array
    {
        return [
            'RISE POLE' => $this,
        ];
    }
    public function startRow(): int
    {
        return 2;
    }
}
