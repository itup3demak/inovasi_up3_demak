<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\DataPelangganExport;
use App\Exports\TrafoExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\DataPelangganAPPImport;
use App\Imports\DataPelangganImport;
use App\Imports\DataPohonImport;
use App\Imports\DataTrafoImport;
use App\Imports\DataZoneImport;
use App\Imports\PenyulangImport;
use App\Imports\SectionImport;
use App\Imports\TrafoImport;
use App\Models\DataPelangganModel;
use App\Models\DataPohonModel;
use App\Models\DataTrafoModel;
use App\Models\DataZoneModel;
use App\Models\EntriPadamModel;
use App\Models\PelangganAPPModel;
use App\Models\PenyulangModel;
use App\Models\SectionModel;
use App\Models\TrafoModel;
use App\Models\UnitModel;
use App\Models\WANotifModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;


class UpdatingController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Peta Pelanggan',
            'data_pelanggan_app' => PelangganAPPModel::all(),
            'data_padam' => DB::table('entri_padam')->select('status', 'section')->get(),
            'data_peta' => DB::table('data_pelanggan')->select('id', 'nama', 'alamat', 'maps', 'latitude', 'longtitude', 'nama_section', 'nohp_stakeholder', 'unitulp')->get(),
            'data_unitulp' => DataPelangganModel::pluck('unitulp'),
            'auth_unit_ulp' => auth()->user(),
        ];
        if (Auth::user()->role === 'administrator') {
            return view('beranda_administrator/index', $data);
        } else if (Auth::user()->role === 'user') {
            return view('beranda_user/index', $data);
        } else {
            return view('beranda_koordinator.index', $data);
        }
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
        return view('beranda_administrator/entripadam', $data);
    }

    public function updating()
    {
        $data = [
            'title' => 'Updating',
            'data_pelanggan' => DataPelangganModel::all(),
            'data_trafo' => TrafoModel::all(),
            'data_trafo2' => DataTrafoModel::all(),
            'data_unit' => UnitModel::all(),
            'data_wanotif' => WANotifModel::all(),
            'data_zone' => DataZoneModel::all(),
            'data_pohon' => DataPohonModel::all(),
        ];
        return view('beranda_administrator/updating', $data);
    }

    public function edit_pelanggan(Request $request, $id)
    {
        DataPelangganModel::find($id)->update($request->all());
        Session::flash('success_edit_pelanggan', 'data pelanggan berhasil diedit');
        return redirect('/updating');
    }
    public function edit_trafo(Request $request, $id)
    {
        TrafoModel::find($id)->update($request->all());
        Session::flash('success_edit_trafo', 'trafo berhasil diedit');
        return redirect('/updating');
    }
    public function edit_datazone(Request $request, $id)
    {
        DataZoneModel::find($id)->update($request->all());
        Session::flash('success_edit_datazone', 'datazone berhasil diedit');
        return redirect('/updating');
    }
    public function edit_datapohon(Request $request, $id)
    {
        DataPohonModel::find($id)->update($request->all());
        Session::flash('success_edit_datapohon', 'data berhasil diedit');
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
    public function import_excel_datazone(Request $request)
    {
        // $this->validate($request, [
        //     'file' => 'required|mimes:csv,xls,xlsx'
        // ]);
        $file = $request->file('file_datazone');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_datazone', $nama_file);
        Excel::import(new DataZoneImport, public_path('/file_datazone/' . $nama_file));

        return redirect('/updating');
    }
    public function import_excel_datapohon(Request $request)
    {
        $file = $request->file('file_datapohon');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_datapohon', $nama_file);
        Excel::import(new DataPohonImport, public_path('/file_datapohon/' . $nama_file));
        
        return redirect('/updating');
    }
    public function import_excel_datatrafo(Request $request)
    {
        $file = $request->file('file_datatrafo');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_datatrafo', $nama_file);
        Excel::import(new DataTrafoImport, public_path('/file_datatrafo/' . $nama_file));

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
    public function form_edit_pelanggan($id)
    {
        $data = [
            'title' => 'Form Edit Pelanggan',
            'pelanggan' => DataPelangganModel::find($id)
        ];
        return view('beranda_administrator/FormEdit/editpelanggan', $data);
    }
    public function form_edit_datazone($id)
    {
        $data = [
            'title' => 'Form Edit Data Zone',
            'datazone' => DataZoneModel::find($id)
        ];
        return view('beranda_administrator/FormEdit/editdatazone', $data);
    }
    public function form_edit_datapohon($id)
    {
        $data = [
            'title' => 'Form Edit Data Pohon',
            'datapohon' => DataPohonModel::find($id)
        ];
        return view('beranda_administrator/FormEdit/editdatapohon', $data);
    }
    public function hapusPelanggan(Request $request)
    {
        $hapus_items = $request->input('checkPelanggan');
        if ($hapus_items) {
            foreach ($hapus_items as $hapus) {
                $pelanggan = DataPelangganModel::find($hapus);
                $pelanggan->delete();
            }
            Session::flash('success_hapus_pelanggan', 'data pelanggan berhasil dihapus');
        } else {
            Session::flash('error_hapus_pelanggan', 'Data gagal dihapus');
        }
        return redirect('/updating');
    }
    public function form_edit_trafo($id)
    {
        $data = [
            'title' => 'Form Edit Trafo',
            'trafo' => TrafoModel::find($id)
        ];
        return view('beranda_administrator/FormEdit/edittrafo', $data);
    }
    public function hapusTrafo(Request $request)
    {
        $hapus_items = $request->input('checkTrafo');
        if ($hapus_items) {
            foreach ($hapus_items as $hapus) {
                $trafo = TrafoModel::find($hapus);
                $trafo->delete();
            }
            Session::flash('success_hapus_trafo', 'data trafo berhasil dihapus');
        } else {
            Session::flash('error_hapus_trafo', 'data trafo gagal dihapus');
        }
        return redirect('/updating');
    }
    public function form_edit_data_unit($id)
    {
        $data = [
            'title' => 'Form Edit Data Unit',
            'dataunit' => UnitModel::find($id)
        ];
        return view('beranda_administrator/FormEdit/editdataunit', $data);
    }
    public function proses_tambah_dataunit(Request $request)
    {
        $message = ['required' => ':attribute harus diisi'];
        $validateData = $request->validate([
            'unit' => 'required',
            'no_mulp' => 'required',
            'no_tlteknik' => 'required',
        ], $message);

        if ($validateData) {
            UnitModel::create([
                'idunit' => $request->input('idunit'),
                'unit' => $request->input('unit'),
                'no_mulp' => $request->input('no_mulp'),
                'no_tlteknik' => $request->input('no_tlteknik'),
            ]);

            Session::flash('success_tambah_dataunit', 'data unit berhasil ditambahkan');
        } else {
            Session::flash('error_tambah_dataunit', 'data unit gagal ditambahkan');
        }
        return redirect('/updating');
    }
    public function edit_unit(Request $request, $id)
    {
        $message = ['required' => ':attribute harus diisi'];
        $validateData = $request->validate([
            // 'unit' => 'required',
            'no_mulp' => 'required',
            'no_tlteknik' => 'required',
        ], $message);
        if ($validateData) {
            $dataunit = UnitModel::find($id);
            $dataunit->update([
                // 'idunit' => $request->input('idunit'),
                // 'unit' => $request->input('unit'),
                'no_mulp' => $request->input('no_mulp'),
                'no_tlteknik' => $request->input('no_tlteknik'),
                $validateData
            ]);
            Session::flash('success_edit_unit', 'data unit berhasil diedit');
            return redirect('/updating');
        } else {
            Session::flash('error_edit_unit', 'data unit gagal diedit');
            return redirect('/updating');
        }
    }
    public function hapusDataUnit(Request $request)
    {
        $hapus_items = $request->input('checkDataUnit');
        if ($hapus_items) {
            foreach ($hapus_items as $hapus) {
                $dataunit = UnitModel::find($hapus);
                $dataunit->delete();
            }
            Session::flash('success_hapus_unit', 'data unit berhasil dihapus');
        } else {
            Session::flash('error_hapus_unit', 'data unit gagal dihapus');
        }
        return redirect('/updating');
    }
    public function form_edit_wa_notif($id)
    {
        $data = [
            'title' => 'Form Edit WA Notif',
            'wanotif' => WANotifModel::find($id)
        ];
        return view('beranda_administrator/FormEdit/editwanotif', $data);
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
    public function hapusWANotif(Request $request)
    {
        $hapus_items = $request->input('checkWANotif');
        if ($hapus_items) {
            foreach ($hapus_items as $hapus) {
                $wanotif = WANotifModel::find($hapus);
                $wanotif->delete();
            }
            Session::flash('success_hapus_wanotif', 'wanotif berhasil dihapus');
        } else {
            Session::flash('error_hapus_wanotif', 'wanotif gagal dihapus');
        }
        return redirect('/updating');
    }
    public function hapusDataZone(Request $request)
    {
        $hapus_items = $request->input('checkDataZone');
        if ($hapus_items) {
            foreach ($hapus_items as $hapus) {
                $datazone = DataZoneModel::find($hapus);
                $datazone->delete();
            }
            Session::flash('success_hapus_datazone', 'datazone berhasil dihapus');
        } else {
            Session::flash('error_hapus_datazone', 'datazone gagal dihapus');
        }
        return redirect('/updating');
    }
    public function hapusDataPohon(Request $request)
    {
        $hapus_items = $request->input('checkDataPohon');
        if ($hapus_items) {
            foreach ($hapus_items as $hapus) {
                $datazone = DataPohonModel::find($hapus);
                $datazone->delete();
            }
            Session::flash('success_hapus_datazone', 'data berhasil dihapus');
        } else {
            Session::flash('error_hapus_datazone', 'data gagal dihapus');
        }
        return redirect('/updating');
    }
}
