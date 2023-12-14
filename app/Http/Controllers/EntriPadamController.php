<?php

namespace App\Http\Controllers;

use App\Models\EntriPadamModel;
use App\Models\DataPelangganModel;
use Illuminate\Support\Facades\Session;
use App\Imports\DataPelangganImport;
use App\Imports\PenyulangImport;
use App\Imports\SectionImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Section;
use EntriPadam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class EntriPadamController extends Controller
{
    public function index()
    {
        $data_section = EntriPadamModel::pluck('section');
        $sections = [];
        foreach ($data_section as $section) {
            $sections[$section] = EntriPadamModel::where('section', $section)->count();
        }
        $data = [
            'title' => 'Transaksi Padam',
            'data_padam' => EntriPadamModel::all(),
            'data_section' => $data_section,
            'sections' => $sections
        ];
        return view('beranda/transaksipadam', $data);
    }
    public function insertEntriPadam(Request $request)
    {
        $message = [
            'required' => ':attribute harus diisi',
            'max' => ':attribute maximal 255 kata',
            'min' => ':attribute minimal 2 kata',
            'email' => ':attribute tidak valid',
        ];
        $validateData = $request->validate([
            'penyulang' => 'required',
            'section' => 'required',
            'penyebab_padam' => 'required',
            'jam_padam' => 'required',
        ], $message);
        if ($request->has('section')) {
            $sections = $request->input('section');
            foreach ($sections as $section) {
                EntriPadamModel::create([
                    'section' => $section,
                    'penyulang' => $request->penyulang,
                    'penyebab_padam' => $request->penyebab_padam,
                    'jam_padam' => date("d-m-Y H:i", strtotime(str_replace('T', ' ', $request->jam_padam))),
                    'keterangan' => $request->keterangan,
                    'status' => $request->status,
                    $validateData
                ]);
            }
            Session::flash('success_tambah', 'Data berhasil ditambah');
            return redirect('/transaksipadam');
        } else {
            return redirect('/entripadam');
        }
    }
    public function hapusEntriPadam()
    {
        $hapus_entri = request('check');
        if ($hapus_entri) {
            foreach ($hapus_entri as $hapus) {
                $padam = EntriPadamModel::find($hapus);
                $padam->delete();
            }
            Session::flash('success_hapus', 'Data berhasil dihapus');
            return redirect('/transaksipadam');
        } else {
            Session::flash('success_hapus', 'Data berhasil dihapus');
            return redirect('/transaksipadam');
        }
    }
    public function editStatusPadam(Request $request)
    {
        $message = [
            'required' => ':attribute harus diisi',
            'max' => ':attribute maximal 255 kata',
            'min' => ':attribute minimal 2 kata',
            'email' => ':attribute tidak valid',
        ];
        $request->validate([
            'jam_nyala' => 'required',
            'penyebab_fix' => 'required',
        ], $message);
        $update_status = request('check');
        $penyebab_fix = $request->input('penyebab_fix');
        $jam_nyala = date("d-m-Y H:i", strtotime(str_replace('T', ' ', $request->input('jam_nyala'))));
        if ($update_status) {
            foreach ($update_status as $status) {
                $status_update = EntriPadamModel::where('id', $status);
                $status_update->update([
                    'status' => $request->status,
                    'jam_nyala' => $jam_nyala,
                    'penyebab_fix' => $penyebab_fix,
                    // $validateData
                ]);
            }
            Session::flash('success_nyala', 'Section berhasil dinyalakan');
            return redirect('/transaksipadam');
        } else {
            Session::flash('error_nyala', 'Section gagal dinyalakan');
            return redirect('/transaksipadam');
        }
    }
    public function petapadam()
    {
        $data = [
            'title' => 'Peta Padam',
            'data_padam' => EntriPadamModel::all(),
            'data_pelanggan' => DataPelangganModel::all(),
            'id' => DB::table('entri_padam')->select('id')->get(),
        ];
        return view('beranda/petapadam', $data);
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

        return redirect('/entripadam');
    }
}
