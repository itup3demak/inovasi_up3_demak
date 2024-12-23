<?php

namespace App\Http\Controllers;

use App\Exports\PelangganPadamExport;
use App\Exports\SectionExport;
use App\Exports\TrafoExport;
use App\Models\EntriPadamModel;
use App\Models\DataPelangganModel;
use Illuminate\Support\Facades\Session;
use App\Imports\DataPelangganImport;
use App\Imports\PenyulangImport;
use App\Imports\SectionImport;
use App\Models\DataPegawaiModel;
use App\Models\DataPohonModel;
use App\Models\DataTrafoModel;
use App\Models\DataZoneModel;
use App\Models\PelangganPadamModel;
use App\Models\RekapKaliPadamModel;
use App\Models\TrafoModel;
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
        $data_padam = EntriPadamModel::all();
        $rekap_section = DB::table('entri_padam')
            ->leftJoin('section', 'entri_padam.section', '=', 'section.id_apkt')
            ->select('section.nama_section', 'entri_padam.penyebab_padam', 'entri_padam.nama_pelanggan', 'entri_padam.section', DB::raw('COUNT(*) as jumlah_entri'))
            ->groupBy('section.nama_section', 'entri_padam.penyebab_padam', 'entri_padam.nama_pelanggan', 'entri_padam.section')
            ->get();
        foreach ($rekap_section as $item_section) {
            DB::table('entri_padam')
                ->where('section', $item_section->section)
                ->update(['status_wa' => 'Sudah Terkirim', 'kalipadam' => $item_section->jumlah_entri]);
        }

        foreach ($data_padam as $data) {
            $waktuPadam = strtotime($data->jam_padam);
            $waktuNyala = strtotime($data->jam_nyala);
            $durasiDetik = $waktuNyala - $waktuPadam;

            $durasiJam = floor($durasiDetik / (60 * 60));
            $durasiMenit = floor(($durasiDetik % (60 * 60)) / 60);
            $durasiPadam = $durasiJam . ' jam ' . $durasiMenit . ' menit';
            EntriPadamModel::where('id', $data->id)->update(['durasi_padam' => $durasiPadam]);
        }

        $data = [
            'title' => 'Transaksi Histori',
            'data_padam' => $data_padam,
            'rekap_section' => $rekap_section,
        ];

        return view('beranda_administrator/transaksipadam', $data);
    }
    public function transaksiaktif()
    {
        $data_padam = EntriPadamModel::all();
        $rekap_pelanggan = DB::table('entri_padam')
            ->leftJoin('data_pelanggan', 'entri_padam.section', '=', 'data_pelanggan.nama_section')
            ->select('data_pelanggan.nama', 'data_pelanggan.maps', 'data_pelanggan.alamat', 'data_pelanggan.nohp_stakeholder', 'entri_padam.penyebab_padam', 'entri_padam.keterangan')
            ->groupBy('data_pelanggan.nama', 'data_pelanggan.maps', 'data_pelanggan.alamat', 'data_pelanggan.nohp_stakeholder', 'entri_padam.penyebab_padam', 'entri_padam.keterangan')
            ->where('entri_padam.status', '=', 'Padam')
            ->get();
        $rekap_instalasi = DB::table('entri_padam')
            ->leftJoin('data_pelanggan', 'entri_padam.nama_pelanggan', '=', 'data_pelanggan.nama')
            ->select('data_pelanggan.nama', 'data_pelanggan.maps', 'data_pelanggan.alamat', 'data_pelanggan.nohp_stakeholder', 'entri_padam.penyebab_padam', 'entri_padam.keterangan')
            ->groupBy('data_pelanggan.nama', 'data_pelanggan.maps', 'data_pelanggan.alamat', 'data_pelanggan.nohp_stakeholder', 'entri_padam.penyebab_padam', 'entri_padam.keterangan')
            ->where('entri_padam.status', '=', 'Padam')
            ->get();

        $data = [
            'title' => 'Transaksi Aktif',
            'data_padam' => $data_padam,
            'rekap_pelanggan' => $rekap_pelanggan,
            'rekap_instalasi' => $rekap_instalasi
        ];
        return view('beranda_administrator/transaksiaktif', $data);
    }
    public function insertEntriPadam(Request $request)
    {
        $message = [
            'required' => ':attribute harus diisi',
        ];
        $validateData = $request->validate([
            'penyebab_padam' => 'required',
            'jam_padam' => 'required',
            'keterangan' => 'required',
        ], $message);

        // Insert data EntriPadamModel
        if ($request->penyebab_padam == 'Gangguan' && $request->has('section')) {
            $sections = $request->input('section');
            foreach ($sections as $section) {
                EntriPadamModel::create([
                    'section' => $section,
                    'penyulang' => $request->penyulang,
                    'penyebab_padam' => $request->penyebab_padam,
                    'jam_padam' => date("d-m-Y H:i", strtotime(str_replace('T', ' ', $request->jam_padam))),
                    'keterangan' => $request->keterangan,
                    'status' => $request->status,
                    'status_wa' => $request->status_wa,
                    $validateData
                ]);
            }

            $rekap_pelanggan = DB::table('entri_padam')
                ->leftJoin('data_pelanggan', 'entri_padam.section', '=', 'data_pelanggan.nama_section')
                ->select('data_pelanggan.idpel', 'data_pelanggan.nama', 'data_pelanggan.alamat', 'data_pelanggan.nohp_stakeholder', 'data_pelanggan.unitulp', 'entri_padam.penyebab_padam', 'entri_padam.keterangan', 'entri_padam.section', 'entri_padam.penyulang')
                ->groupBy('data_pelanggan.idpel', 'data_pelanggan.nama', 'data_pelanggan.alamat', 'data_pelanggan.nohp_stakeholder', 'data_pelanggan.unitulp', 'entri_padam.penyebab_padam', 'entri_padam.keterangan', 'entri_padam.section', 'entri_padam.penyulang')
                ->where('entri_padam.status_wa', '=', 'Sedang Mengirim')
                ->get();

            $target = '';
            $targetMULP = '';
            $MULPDemak = '6289531584234';
            $MULPTegowanu = '62895341999397';

            foreach ($rekap_pelanggan as $rekap) {
                $target .= $rekap->nohp_stakeholder . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                if ($rekap->unitulp == '52551') {
                    $targetMULP .= $MULPDemak . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
                if ($rekap->unitulp == '52552') {
                    $targetMULP .= $MULPTegowanu . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
                if ($rekap->unitulp == '52553') {
                    $targetMULP .= $MULPTegowanu . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
                if ($rekap->unitulp == '52554') {
                    $targetMULP .= $MULPTegowanu . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
            }
            // Kirim pesan menggunakan cURL
            // $curl = curl_init();
            // curl_setopt_array($curl, [
            //     CURLOPT_URL => 'https://api.fonnte.com/send',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => [
            //         'target' => $target,
            //         'message' => 'Yth. Pelanggan {name} Mohon maaf atas gangguan listrik yang terjadi di lokasi Anda karena {var1}. Saat ini sedang dalam penanganan petugas PLN. Terimakasih',
            //         'delay' => '2',
            //         'countryCode' => '62', //optional
            //     ],
            //     CURLOPT_HTTPHEADER => [
            //         'Authorization: ZKzMEW@7r#17gbjDQRBv', //change TOKEN to your actual token
            //     ],
            // ]);

            // $response = curl_exec($curl);
            // curl_close($curl);

            // $curl = curl_init();
            // curl_setopt_array($curl, [
            //     CURLOPT_URL => 'https://api.fonnte.com/send',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => [
            //         'target' => $targetMULP,
            //         'message' => 'Yth. Pelanggan {name} Mohon maaf atas gangguan listrik yang terjadi di lokasi Anda karena {var1}. Saat ini sedang dalam penanganan petugas PLN. Terimakasih (Ini Pesan Untuk MULP)',
            //         'delay' => '2',
            //         'countryCode' => '62', //optional
            //     ],
            //     CURLOPT_HTTPHEADER => [
            //         'Authorization: ZKzMEW@7r#17gbjDQRBv', //change TOKEN to your actual token
            //     ],
            // ]);

            // $response = curl_exec($curl);
            // curl_close($curl);
            Session::flash('success_tambah', 'Entri Padam berhasil ditambah');
            return redirect('/entripadam');
        } elseif ($request->penyebab_padam == 'Instalasi' && $request->has('nama_pelanggan')) {
            EntriPadamModel::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'penyebab_padam' => $request->penyebab_padam,
                'jam_padam' => date("d-m-Y H:i", strtotime(str_replace('T', ' ', $request->jam_padam))),
                'keterangan' => $request->keterangan,
                'status' => $request->status,
                'status_wa' => $request->status_wa,
            ]);
            $rekap_instalasi = DB::table('entri_padam')
                ->leftJoin('data_pelanggan', 'entri_padam.nama_pelanggan', '=', 'data_pelanggan.nama')
                ->select('data_pelanggan.nama', 'data_pelanggan.maps', 'data_pelanggan.alamat', 'data_pelanggan.nohp_stakeholder', 'data_pelanggan.unitulp', 'entri_padam.penyebab_padam', 'entri_padam.keterangan')
                ->groupBy('data_pelanggan.nama', 'data_pelanggan.maps', 'data_pelanggan.alamat', 'data_pelanggan.nohp_stakeholder', 'data_pelanggan.unitulp', 'entri_padam.penyebab_padam', 'entri_padam.keterangan')
                ->where('entri_padam.status_wa', '=', 'Sedang Mengirim')
                ->get();

            $target = '';
            $targetMULP = '';
            $MULPDemak = '6289531584234';
            $MULPTegowanu = '62895341999397';

            foreach ($rekap_instalasi as $rekap) {
                $target .= $rekap->nohp_stakeholder . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                if ($rekap->unitulp == '52551') {
                    $targetMULP .= $MULPDemak . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
                if ($rekap->unitulp == '52552') {
                    $targetMULP .= $MULPTegowanu . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
                if ($rekap->unitulp == '52553') {
                    $targetMULP .= $MULPTegowanu . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
                if ($rekap->unitulp == '52554') {
                    $targetMULP .= $MULPTegowanu . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
            }
            // Kirim pesan menggunakan cURL
            // $curl = curl_init();
            // curl_setopt_array($curl, [
            //     CURLOPT_URL => 'https://api.fonnte.com/send',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => [
            //         'target' => $target,
            //         'message' => 'Yth. Pelanggan {name} Mohon maaf atas gangguan listrik yang terjadi di lokasi Anda karena {var1}. Saat ini sedang dalam penanganan petugas PLN. Terimakasih',
            //         'delay' => '2',
            //         'countryCode' => '62', //optional
            //     ],
            //     CURLOPT_HTTPHEADER => [
            //         'Authorization: ZKzMEW@7r#17gbjDQRBv', //change TOKEN to your actual token
            //     ],
            // ]);

            // $response = curl_exec($curl);
            // curl_close($curl);

            // $curl = curl_init();
            // curl_setopt_array($curl, [
            //     CURLOPT_URL => 'https://api.fonnte.com/send',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => [
            //         'target' => $targetMULP,
            //         'message' => 'Yth. Pelanggan {name} Mohon maaf atas gangguan listrik yang terjadi di lokasi Anda karena {var1}. Saat ini sedang dalam penanganan petugas PLN. Terimakasih (Ini Pesan Untuk MULP)',
            //         'delay' => '2',
            //         'countryCode' => '62', //optional
            //     ],
            //     CURLOPT_HTTPHEADER => [
            //         'Authorization: ZKzMEW@7r#17gbjDQRBv', //change TOKEN to your actual token
            //     ],
            // ]);

            // $response = curl_exec($curl);
            // curl_close($curl);
            Session::flash('success_tambah', 'Entri Padam berhasil ditambah');
            return redirect('/entripadam');
        } else {
            // Jika tidak ada bagian yang dipilih
            Session::flash('error_tambah', 'Entri Padam berhasil ditambah');
            return redirect('/entripadam');
        }
    }

    public function editStatusPadam(Request $request)
    {
        $message = [
            'required' => ':attribute harus diisi',
        ];
        $request->validate([
            'jam_nyala' => 'required',
            'penyebab_fix' => 'required',
        ], $message);
        $update_status = request('checkPadam');
        $penyebab_fix = $request->input('penyebab_fix');
        $jam_nyala = date("d-m-Y H:i", strtotime(str_replace('T', ' ', $request->input('jam_nyala'))));
        if ($update_status) {
            foreach ($update_status as $status) {
                $status_update = EntriPadamModel::where('id', $status);
                $status_update->update([
                    'status' => $request->status,
                    'status_wa' => $request->status_wa,
                    'jam_nyala' => $jam_nyala,
                    'penyebab_fix' => $penyebab_fix,
                ]);
            }
            // Ambil data pelanggan dan kirim pesan setelah entri berhasil dimasukkan
            // Ambil data pelanggan dan kirim pesan setelah entri berhasil dimasukkan
            $rekap_pelanggan = DB::table('entri_padam')
                ->leftJoin('data_pelanggan', function ($join) {
                    $join->on('entri_padam.section', '=', 'data_pelanggan.nama_section')
                        ->orOn('entri_padam.nama_pelanggan', '=', 'data_pelanggan.nama');
                })
                ->select('data_pelanggan.idpel', 'data_pelanggan.nama', 'data_pelanggan.alamat', 'data_pelanggan.nohp_stakeholder', 'data_pelanggan.unitulp', 'entri_padam.penyebab_padam', 'entri_padam.keterangan', 'entri_padam.section', 'entri_padam.penyulang')
                ->groupBy('data_pelanggan.idpel', 'data_pelanggan.nama', 'data_pelanggan.alamat', 'data_pelanggan.nohp_stakeholder', 'data_pelanggan.unitulp', 'entri_padam.penyebab_padam', 'entri_padam.keterangan', 'entri_padam.section', 'entri_padam.penyulang')
                ->where('entri_padam.status_wa', 'Sedang Mengirim')
                ->get();

            $target = '';
            $targetMULP = '';
            $MULPDemak = '6289531584234';
            $MULPTegowanu = '62895341999397';
            foreach ($rekap_pelanggan as $rekap) {
                $target .= $rekap->nohp_stakeholder . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                if ($rekap->unitulp == '52551') {
                    $targetMULP .= $MULPDemak . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
                if ($rekap->unitulp == '52552') {
                    $targetMULP .= $MULPTegowanu . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
                if ($rekap->unitulp == '52553') {
                    $targetMULP .= $MULPTegowanu . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
                if ($rekap->unitulp == '52554') {
                    $targetMULP .= $MULPTegowanu . '|' . $rekap->nama . '|' . $rekap->keterangan . ',';
                }
            }
            // Kirim pesan menggunakan cURL
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'target' => $target,
                    'message' => 'Yth. Pelanggan {name}, untuk jaringan listrik sudah kembali normal. Mohon maaf tidak ketidaknyamanan nya',
                    'delay' => '2',
                    'countryCode' => '62', //optional
                ],
                CURLOPT_HTTPHEADER => [
                    'Authorization: ZKzMEW@7r#17gbjDQRBv', //change TOKEN to your actual token
                ],
            ]);
            $response = curl_exec($curl);
            curl_close($curl);

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'target' => $targetMULP,
                    'message' => 'Yth. Pelanggan {name}, untuk jaringan listrik sudah kembali normal. Mohon maaf tidak ketidaknyamanan nya (Ini pesan untuk MULP)',
                    'delay' => '2',
                    'countryCode' => '62', //optional
                ],
                CURLOPT_HTTPHEADER => [
                    'Authorization: ZKzMEW@7r#17gbjDQRBv', //change TOKEN to your actual token
                ],
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            Session::flash('success_nyala', 'Jaringan berhasil dinyalakan');
            return redirect('/transaksihistori');
        } else {
            Session::flash('error_nyala', 'Jaringan gagal dinyalakan karena belum dipilih');
            return redirect('/transaksiaktif');
        }
    }
    public function petapadam()
    {
        $padam = DB::table('data_pelanggan')
            ->leftJoin('entri_padam', function ($join) {
                $join->on('data_pelanggan.nama_section', '=', 'entri_padam.section')
                    ->orOn('data_pelanggan.nama', '=', 'entri_padam.nama_pelanggan');
            })
            ->select('data_pelanggan.nama', 'data_pelanggan.id', 'data_pelanggan.alamat', 'data_pelanggan.maps', 'data_pelanggan.latitude', 'data_pelanggan.longtitude', 'data_pelanggan.nohp_stakeholder', 'data_pelanggan.unitulp', 'entri_padam.section')
            ->where('entri_padam.status', '=', 'Padam')
            ->get();

        $data = [
            'title' => 'Peta Padam',
            'padam' => $padam,
            'data_unitulp' => DataPelangganModel::pluck('unitulp')
        ];
        return view('beranda_administrator/petapadam', $data);
    }
    public function peta_trafo()
    {
        $trafo = DB::table('data_trafo')
            ->select('id', 'kategori', 'penyulang', 'unit_layanan', 'no_tiang', 'daya', 'lokasi', 'bebanA',  'latitude', 'longtitude')
            ->get();

        $data = [
            'title' => 'Peta Trafo',
            'trafo' => $trafo,
            'unit_layanan' => TrafoModel::pluck('unit_layanan'),
            'kategori' => TrafoModel::pluck('kategori'),
            'data_trafo' => $trafo
        ];
        return view('beranda_administrator/petatrafo', $data);
    }
    public function peta_zone()
    {
        $data = [
            'title' => 'Peta Zone',
            'data_zone' => DataZoneModel::all(),
        ];
        return view('beranda_administrator/petazone', $data);
    }
    public function datapohon()
    {
        $data = [
            'title' => 'Data Pohon',
            'datapohon' => DataPohonModel::all(),
            'datarayon' => DataPohonModel::pluck('rayon')
        ];
        return view('beranda_administrator/datapohon', $data);
    }
    public function datatrafo()
    {
        $data = [
            'title' => 'Data Trafo',
            'datatrafo' => DataTrafoModel::all(),
            'dataklasifikasi' => DataTrafoModel::pluck('klasifikasi_beban'),
            'datarayon' => DataTrafoModel::pluck('rayon'),
        ];
        return view('beranda_administrator/datatrafo', $data);
    }
    public function export_kali_padam()
    {
        $rekapKaliPadamModel = new RekapKaliPadamModel();
        $rekapkaliPadam = $rekapKaliPadamModel->getRekapSection();
        date_default_timezone_set('Asia/Jakarta');
        return Excel::download(new SectionExport($rekapkaliPadam), 'Section_Jumlah_Padam '  . date('d-m-Y') . '.xlsx');
    }
    public function export_pelanggan_padam()
    {
        $pelangganPadamModel = new PelangganPadamModel();
        $pelangganPadam = $pelangganPadamModel->getPelangganModel();
        date_default_timezone_set('Asia/Jakarta');
        return Excel::download(new PelangganPadamExport($pelangganPadam), 'Pelanggan_Padam ' . date('d-m-Y') . '.xlsx');
    }
    public function export_pelanggan_padam_csv()
    {
        $pelangganPadamModel = new PelangganPadamModel();
        $pelangganPadam = $pelangganPadamModel->getPelangganModel();
        date_default_timezone_set('Asia/Jakarta');
        return Excel::download(new PelangganPadamExport($pelangganPadam), 'Pelanggan_Padam ' . date('d-m-Y') . '.csv');
    }
}
