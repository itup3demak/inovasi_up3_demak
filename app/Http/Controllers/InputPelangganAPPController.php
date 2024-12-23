<?php

namespace App\Http\Controllers;

use App\Exports\APPExport;
use App\Imports\DataGIImport;
use App\Imports\DataPelangganAPPImport;
use App\Imports\DataPelangganImport;
use App\Imports\ManajemenAsetImport;
use App\Models\DataGIModel;
use App\Models\DataPelangganModel;
use App\Models\ManajemenAset;
use App\Models\PelangganAPPModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InputPelangganAPPController extends Controller
{
    public function user()
    {
        $data = [
            'title' => 'Peta Pelanggan',
            // 'data_padam' => DB::table('entri_padam')->select('status', 'section')->get(),
            'data_pelanggan_app' => DB::table('entri_pelanggan_app')->select('id', 'id_pelanggan', 'nama_pelanggan', 'tarif_daya', 'alamat', 'latitude', 'longitude', 'jenis_meter', 'merk_meter', 'unit_ulp')->get(),
            'auth_unit_ulp' => auth()->user()->unit_ulp,
            // 'data_unitulp' => PelangganAPPModel::pluck('unitulp')
        ];
        return view('beranda_user/index', $data);
    }
    public function entridata_user()
    {
        $data = [
            'title' => 'Entri Data',
            'auth_unit_ulp' => auth()->user()->unit_ulp,
            'data_pelanggan_app' => DB::table('entri_pelanggan_app')->select('id', 'id_pelanggan', 'nama_pelanggan', 'tarif_daya', 'alamat', 'latitude', 'longitude', 'jenis_meter', 'merk_meter', 'unit_ulp')->get(),
        ];
        return view('beranda_user/entridata_user', $data);
    }
    public function manajemen_aset_jaringan()
    {
        // Data untuk view
        $data = [
            'title' => 'Manajemen Aset Jaringan',
            'data_aset' => ManajemenAset::all(),
            'data_gi' => DataGIModel::all(),
            'data_pelanggan_app' => PelangganAPPModel::all(),
            'total_daya_terpakai' => DataGIModel::sum('daya_terpakai')
        ];

        return view('beranda_koordinator/manajemen_aset_jaringan', $data);
    }
    public function map_aset()
    {
        $data = [
            'title' => 'Map Aset',
            'data_aset' => ManajemenAset::all(),
            'data_pelanggan_app' => PelangganAPPModel::all(),
        ];
        return view('beranda_koordinator.map_aset', $data);
    }

    public function updating_koordinator()
    {
        $data = [
            'title' => 'Updating Koordinator',
        ];
        return view('beranda_koordinator/updating_koordinator', $data);
    }
    public function proses_input_pelangganapp(Request $request)
    {
        $message = ['required' => ':attribute harus diisi'];
        $validateData = $request->validate([
            // 'id_pelanggan' => 'required',
            // 'nama_pelanggan' => 'required',
            // 'tarif_daya' => 'required',
            // 'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'jenis_meter' => 'required',
            'merk_meter' => 'required',
            'tahun_meter' => 'required',
            'nomor_meter' => 'required',
            'merk_mcb' => 'required',
            'ukuran_mcb' => 'required',
            'no_segel' => 'required',
            'no_gardu' => 'required',
            'sr_deret' => 'required',
            'unit_ulp' => 'required',
        ], $message);

        if ($validateData) {
            PelangganAPPModel::create([
                'id_pelanggan' => $request->input('id_pelanggan'),
                'nama_pelanggan' => $request->input('nama_pelanggan'),
                'tarif_daya' => $request->input('tarif_daya'),
                'alamat' => $request->input('alamat'),
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'jenis_meter' => $request->input('jenis_meter'),
                'merk_meter' => $request->input('merk_meter'),
                'tahun_meter' => $request->input('tahun_meter'),
                'nomor_meter' => $request->input('nomor_meter'),
                'merk_mcb' => $request->input('merk_mcb'),
                'ukuran_mcb' => $request->input('ukuran_mcb'),
                'no_segel' => $request->input('no_segel'),
                'no_gardu' => $request->input('no_gardu'),
                'sr_deret' => $request->input('sr_deret'),
                'catatan' => $request->input('catatan'),
                'unit_ulp' => $request->input('unit_ulp'),
            ]);

            Session::flash('success_tambah_APP', 'APP berhasil ditambahkan');
            return redirect('/user');
        } else {
            Session::flash('error_tambah_APP', 'APP gagal ditambahkan');
            return redirect('/entridata_user');
        }
    }
    public function koordinator()
    {
        $data = [
            'title' => 'Semua Pelanggan APP',
            'data_pelanggan_app' => DB::table('entri_pelanggan_app')->get(),
        ];
        return view('beranda_koordinator.index', $data);
    }
    public function pelanggan_demak()
    {
        $data = [
            'title' => 'Pelanggan Demak',
            'data_pelanggan_app_demak' => DB::table('entri_pelanggan_app')->where('unit_ulp', '=', 'ulp demak')->get(),
        ];
        return view('beranda_koordinator.pelanggan_demak', $data);
    }
    public function pelanggan_tegowanu()
    {
        $data = [
            'title' => 'Pelanggan Tegowanu',
            'data_pelanggan_app_tegowanu' => DB::table('entri_pelanggan_app')->where('unit_ulp', '=', 'ulp tegowanu')->get(),
        ];
        return view('beranda_koordinator.pelanggan_tegowanu', $data);
    }
    public function pelanggan_purwodadi()
    {
        $data = [
            'title' => 'Pelanggan Purwodadi',
            'data_pelanggan_app_purwodadi' => DB::table('entri_pelanggan_app')->where('unit_ulp', '=', 'ulp_purwodadi')->get(),
        ];
        return view('beranda_koordinator.pelanggan_purwodadi', $data);
    }
    public function pelanggan_wirosari()
    {
        $data = [
            'title' => 'Pelanggan Wirosari',
            'data_pelanggan_app_wirosari' => DB::table('entri_pelanggan_app')->where('unit_ulp', '=', 'ulp_wirosari')->get(),
        ];
        return view('beranda_koordinator.pelanggan_wirosari', $data);
    }
    public function import_excel_purwodadi(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $unit_ulp = 'ulp_purwodadi';
        $file = $request->file('file');
        $nama_file = rand() . '_' . $file->getClientOriginalName();
        $file->move('file_pelanggan_app', $nama_file);

        Excel::import(new DataPelangganAPPImport($unit_ulp), public_path('/file_pelanggan_app/' . $nama_file));

        return redirect('/pelanggan_purwodadi')->with('success', 'Data Pelanggan Berhasil Diimpor');
    }
    public function import_excel_wirosari(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $unit_ulp = 'ulp_wirosari';
        $file = $request->file('file');
        $nama_file = rand() . '_' . $file->getClientOriginalName();
        $file->move('file_pelanggan_app', $nama_file);

        Excel::import(new DataPelangganAPPImport($unit_ulp), public_path('/file_pelanggan_app/' . $nama_file));

        return redirect('/pelanggan_wirosari')->with('success', 'Data Pelanggan Berhasil Diimpor');
    }
    public function import_excel_data_aset(Request $request)
    {
        $file = $request->file('file_data_aset');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_data_aset', $nama_file);
        Excel::import(new ManajemenAsetImport, public_path('/file_data_aset/' . $nama_file));

        return redirect('/manajemen_aset_jaringan');
    }
    public function import_excel_data_gi(Request $request)
    {
        $file = $request->file('file_data_gi');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_data_gi', $nama_file);
        Excel::import(new DataGIImport, public_path('/file_data_gi/' . $nama_file));

        return redirect('/manajemen_aset_jaringan');
    }
    public function import_excel_kelengkapan_data_aset(Request $request)
    {
        $file = $request->file('file_kelengkapan_data_aset');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_kelengkapan_data_aset', $nama_file);
        Excel::import(new DataPelangganAPPImport, public_path('/file_kelengkapan_data_aset/' . $nama_file));

        return redirect('/manajemen_aset_jaringan');
    }
    public function export_excel_app(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return Excel::download(new APPExport($startDate, $endDate), 'APP ' . date('d-m-Y') . '.xlsx');
    }
    public function edit_pelanggan_app($id)
    {
        $data = [
            'title' => 'Edit Pelanggan APP',
            'datapelangganapp' => PelangganAPPModel::find($id)
        ];
        return view('beranda_koordinator/edit_pelanggan_app', $data);
    }
    public function proses_edit_pelanggan_app(Request $request, $id)
    {
        $message = ['required' => ':attribute harus diisi'];
        $validateData = $request->validate([
            'id_pelanggan' => 'required',
            'nama_pelanggan' => 'required',
            'tarif_daya' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'jenis_meter' => 'required',
            'merk_meter' => 'required',
            'tahun_meter' => 'required',
            'nomor_meter' => 'required',
            'merk_mcb' => 'required',
            'ukuran_mcb' => 'required',
            'no_segel' => 'required',
            'no_gardu' => 'required',
            'sr_deret' => 'required',
        ], $message);
        if ($validateData) {
            $datapelangganapp = PelangganAPPModel::find($id);
            $datapelangganapp->update([
                'id_pelanggan' => $request->input('id_pelanggan'),
                'nama_pelanggan' => $request->input('nama_pelanggan'),
                'tarif_daya' => $request->input('tarif_daya'),
                'alamat' => $request->input('alamat'),
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'jenis_meter' => $request->input('jenis_meter'),
                'merk_meter' => $request->input('merk_meter'),
                'tahun_meter' => $request->input('tahun_meter'),
                'nomor_meter' => $request->input('nomor_meter'),
                'merk_mcb' => $request->input('merk_mcb'),
                'ukuran_mcb' => $request->input('ukuran_mcb'),
                'no_segel' => $request->input('no_segel'),
                'no_gardu' => $request->input('no_gardu'),
                'sr_deret' => $request->input('sr_deret'),
                'catatan' => $request->input('catatan'),
                // $validateData
            ]);
            Session::flash('success_edit_unit', 'data unit berhasil diedit');
            return redirect('/koordinator');
        } else {
            Session::flash('error_edit_unit', 'data unit gagal diedit');
            return redirect('edit_pelanggan_app/' . $id);
        }
    }
    public function hapusPelangganAPP(Request $request)
    {
        $hapus_items = $request->input('checkPelangganAPP');
        if ($hapus_items) {
            foreach ($hapus_items as $hapus) {
                $pelanggan = PelangganAPPModel::find($hapus);
                $pelanggan->delete();
            }
            Session::flash('success_hapus_pelanggan', 'data pelanggan berhasil dihapus');
        } else {
            Session::flash('error_hapus_pelanggan', 'Data gagal dihapus');
        }
        return redirect('/manajemen_aset_jaringan');
    }
    public function edit_pelanggan_app_user($id_pelanggan)
    {
        $pelanggan = DB::table('entri_pelanggan_app')
            ->where('id_pelanggan', $id_pelanggan)
            ->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Pelanggan tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pelanggan APP',
            'pelanggan' => $pelanggan
        ];

        return view('beranda_user/edit_pelanggan_app_user', $data);
    }
    public function proses_edit_pelanggan_app_user(Request $request, $nama_pelanggan)
    {
        $message = ['required' => ':attribute harus diisi'];
        $validateData = $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'jenis_meter' => 'required',
            'merk_meter' => 'required',
            'tahun_meter' => 'required',
            'nomor_meter' => 'required',
            'merk_mcb' => 'required',
            'ukuran_mcb' => 'required',
            'no_segel' => 'required',
            'no_gardu' => 'required',
            'sr_deret' => 'required',
        ], $message);
        if ($validateData) {
            $datapelangganapp = PelangganAPPModel::find($nama_pelanggan);
            $datapelangganapp->update([
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'jenis_meter' => $request->input('jenis_meter'),
                'merk_meter' => $request->input('merk_meter'),
                'tahun_meter' => $request->input('tahun_meter'),
                'nomor_meter' => $request->input('nomor_meter'),
                'merk_mcb' => $request->input('merk_mcb'),
                'ukuran_mcb' => $request->input('ukuran_mcb'),
                'no_segel' => $request->input('no_segel'),
                'no_gardu' => $request->input('no_gardu'),
                'sr_deret' => $request->input('sr_deret'),
                'catatan' => $request->input('catatan'),
                'unit_ulp' => $request->input('unit_ulp'),
                // $validateData
            ]);
            Session::flash('success_edit_unit', 'data unit berhasil diedit');
            return redirect('/user');
        } else {
            Session::flash('error_edit_unit', 'data unit gagal diedit');
            return redirect('edit_pelanggan_app_user/' . $nama_pelanggan);
        }
    }
}
