<?php

namespace App\Imports;

use App\Models\DataPelangganModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataPelangganImport implements ToModel, WithStartRow, WithMultipleSheets
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use Importable;

    public function model(array $row)
    {
        if ($this->isDuplicate($row)) {
            Session::flash('error_import', 'Data sudah ada. Namun jika ada data tambahan lainnya, maka dapat dicek');
            return null;
        } else {
            Session::flash('success_import', 'File Excel Berhasil Diimport');
            return new DataPelangganModel([
                'idpel' => $row[0],
                'nama' => $row[1],
                'alamat' => $row[2],
                'maps' => $row[3],
                'titik_koordinat' => $row[4],
            ]);
        }
    }

    private function isDuplicate(array $data)
    {
        $existingData = DataPelangganModel::where('idpel', $data['0'])
            ->where('nama', $data['1'])
            ->first();

        return $existingData !== null;
    }
    public function sheets(): array{
        return[
            'KUBIKEL' => new DataPelangganImport()
        ];
    }
    public function startRow(): int
    {
        return 2;
    }
}
