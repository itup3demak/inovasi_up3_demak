<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\DataPelangganExport;
use App\Exports\TrafoExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\DataPelangganImport;
use App\Imports\PenyulangImport;
use App\Imports\SectionImport;
use App\Imports\TrafoImport;
use App\Models\DataPelangganModel;
use App\Models\EntriPadamModel;
use App\Models\PenyulangModel;
use App\Models\SectionModel;
use App\Models\TrafoModel;
use App\Models\UnitModel;
use App\Models\WANotifModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;


class DataPelangganController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Peta Pelanggan',
            'data_padam' => DB::table('entri_padam')->select('status', 'section')->get(),
            'data_peta' => DB::table('data_pelanggan')->select('id', 'nama', 'alamat', 'maps', 'latitude', 'longtitude', 'nama_section', 'nohp_stakeholder', 'unitulp')->get(),
            'data_unitulp' => DataPelangganModel::pluck('unitulp')
        ];
        return view('beranda/index', $data);
    }

    public function entri_padam()
    {
        $data_penyulang = SectionModel::pluck('penyulang')->unique();
        $penyulangs = $data_penyulang->mapWithKeys(function ($penyulang) {
            return [$penyulang => SectionModel::where('penyulang', $penyulang)->pluck('id_apkt')];
        });

        DB::table('entri_padam')->update(['status_wa' => 'Sudah Terkirim']);

        $data = [
            'title' => 'Entri Padam',
            'section' => $penyulangs,
            'nama_pelanggan' => DataPelangganModel::pluck('nama'),
            'data_penyulang' => $data_penyulang,
            'data_section' => PenyulangModel::all(),
        ];
        return view('beranda/entripadam', $data);
    }

    public function updating()
    {
        $data = [
            'title' => 'Updating',
            'data_pelanggan' => DataPelangganModel::all(),
            'data_trafo' => TrafoModel::all(),
            'data_unit' => UnitModel::all(),
            'data_wanotif' => WANotifModel::all(),
        ];
        return view('beranda/updating', $data);
    }
    
    public function edit_pelanggan(Request $request, $id)
    {
        DataPelangganModel::find($id)->update($request->all());
        Session::flash('success_edit', 'Data berhasil diedit');
        return redirect('/updating');
    }
    public function edit_trafo(Request $request, $id)
    {
        TrafoModel::find($id)->update($request->all());
        Session::flash('success_edit', 'Data berhasil diedit');
        return redirect('/updating');
    }
    public function export_excel_pelanggan()
    {
        date_default_timezone_set('Asia/Jakarta');
        return Excel::download(new DataPelangganExport, 'PELANGGAN TM UP3 DEMAK '  . date('d-m-Y') . '.xlsx');
    }
    public function export_excel_trafo()
    {
        date_default_timezone_set('Asia/Jakarta');
        return Excel::download(new TrafoExport, 'Data Trafo '  . date('d-m-Y') . '.xlsx');
    }
    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_pelanggan', $nama_file);
        Excel::import(new DataPelangganImport, public_path('/file_pelanggan/' . $nama_file));
        
        return redirect('/updating');
    }
    public function import_excel_trafo(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_trafo', $nama_file);
        Excel::import(new TrafoImport, public_path('/file_trafo/' . $nama_file));
        
        return redirect('/updating');
    }
    public function import_excel_penyulangsection(Request $request)
    {
        $this->validate($request, [
            'file_penyulang' => 'required|mimes:csv,xls,xlsx',
            'file_section' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file_penyulang = $request->file('file_penyulang');
        $file_section = $request->file('file_section');
        $nama_file_penyulang = rand() . $file_penyulang->getClientOriginalName();
        $nama_file_section = rand() . $file_section->getClientOriginalName();
        $file_penyulang->move('file_penyulang', $nama_file_penyulang);
        $file_section->move('file_section', $nama_file_section);
        Excel::import(new PenyulangImport, public_path('/file_penyulang/' . $nama_file_penyulang));
        Excel::import(new SectionImport, public_path('/file_section/' . $nama_file_section));

        return redirect('/updating');
    }
    public function hapusPelanggan(Request $request)
    {
        $hapus_items = $request->input('checkPelanggan');
        if ($hapus_items) {
            foreach ($hapus_items as $hapus) {
                $pelanggan = DataPelangganModel::find($hapus);
                $pelanggan->delete();
            }
            Session::flash('success_hapus', 'Data berhasil dihapus');
        } else {
            Session::flash('error_hapus', 'Data gagal dihapus');
        }
        return redirect('/updating');
    }
    public function hapusTrafo(Request $request)
    {
        $hapus_items = $request->input('checkTrafo');
        if ($hapus_items) {
            foreach ($hapus_items as $hapus) {
                $trafo = TrafoModel::find($hapus);
                $trafo->delete();
            }
            Session::flash('success_hapus', 'Data berhasil dihapus bro');
        } else {
            Session::flash('error_hapus', 'Data gagal dihapus bro');
        }
        return redirect('/updating');
    }
    public function edit_unit(Request $request, $id)
    {
        $message = ['required' => ':attribute harus diisi'];
        $validateData = $request->validate([
            'no_mulp' => 'required',
            'no_tlteknik' => 'required',
        ], $message);
        if ($validateData) {
            $dataunit = UnitModel::find($id);
            $dataunit->update([
                'no_mulp' => $request->input('no_mulp'),
                'no_tlteknik' => $request->input('no_tlteknik'),
                $validateData
            ]);
            Session::flash('success_edit_unit', 'unit berhasil diedit');
            return redirect('/updating');
        } else {
            Session::flash('error_edit_unit', 'unit gagal diedit');
            return redirect('/updating');
        }
    }
    public function tambah_wanotif(){
        $data = [
            'title' => 'Form Tambah WA Notif',
        ];
        return view('beranda/tambahwanotif', $data);
    }
    public function proses_tambah_wanotif(Request $request)
    {
        $message = ['required' => ':attribute harus diisi'];
        $validateData = $request->validate([
            'idserial' => 'required',
            'idpel' => 'required',
            'idunit' => 'required',
        ], $message);
    
        if ($validateData) {
            WANotifModel::create([
                'idserial' => $request->input('idserial'),
                'idpel' => $request->input('idpel'),
                'idunit' => $request->input('idunit'),
            ]);
    
            Session::flash('success_tambah_wanotif', 'wanotif berhasil ditambahkan');
        } else {
            Session::flash('error_tambah_wanotif', 'wanotif gagal ditambahkan');
        }
        return redirect('/updating');
    }
    public function edit_wanotif(Request $request, $id)
    {
        $message = ['required' => ':attribute harus diisi'];
        $validateData = $request->validate([
            'idserial' => 'required',
            'idpel' => 'required',
            'idunit' => 'required',
        ], $message);
        if ($validateData) {
            $datawanotif = WANotifModel::find($id);
            $datawanotif->update([
                'idserial' => $request->input('idserial'),
                'idpel' => $request->input('idpel'),
                'idunit' => $request->input('idunit'),
                $validateData
            ]);
            Session::flash('success_edit_wanotif', 'wanotif berhasil diedit');
            return redirect('/updating');
        } else {
            Session::flash('error_edit_wanotif', 'wanotif gagal diedit');
            return redirect('/updating');
        }
    }
}
