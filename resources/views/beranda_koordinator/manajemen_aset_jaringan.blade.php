@extends('layout/templateberanda_koordinator')
@section('content')
    <div class="container-fluid mt-2">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="bulanAset">Pilih Bulan:</label>
                <input type="month" id="bulanAset" class="form-control" placeholder="YYYY-MM">
            </div>
            <div class="col-md-2">
                <label>&nbsp;</label>
                <button id="filterAset" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>

        <div style="overflow-y: auto;">
            <h2>Data Aset</h2>
            <table class="table-bordered tabel-app mt-2 display" id="tabel-aset">
                <thead class="text-light" style="background:linear-gradient(#134E5E, #71B280)">
                    <tr>
                        <th>Aksi</th>
                        <th style="display: none">Created At</th>
                        <th>ULP</th>
                        <th>Bulan</th>
                        <th>KMS JTM</th>
                        <th>KMS JTR</th>
                        <th>Jumlah Trafo</th>
                        <th>Total Daya Trafo</th>
                        <th>SR</th>
                        <th>Jumlah Tiang TM</th>
                        <th>Jumlah Tiang TR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_aset as $aset)
                        <tr>
                            <td>
                                <a href="#" data-bs-target="#edit-aset{{ $aset->id }}" data-bs-toggle="modal">
                                    <i class="fa-solid fa-edit fa-lg text-primary"></i>
                                </a>
                                <div class="modal fade" id="edit-aset{{ $aset->id }}" tabindex="-1"
                                    aria-labelledby="modalTambahasetLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="/edit_aset/{{ $aset->id }}" method="post">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-3" id="modalTambahasetLabel">Edit
                                                        Data
                                                        aset
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save
                                                        changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <a href="#" class="col-12 mb-2" data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-pelangganapp">
                                    <i class="fa-solid fa-trash fa-lg text-danger" style="margin-right: 5px;"></i>
                                </a>
                                <div class="modal modal-blur fade" id="modal-delete-pelangganapp" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="/delete_aset/{{ $aset->id }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                                <div class="modal-status bg-danger"></div>
                                                <div class="modal-body text-center py-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon mb-2 text-danger icon-lg" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                                                        <path d="M12 9v4" />
                                                        <path d="M12 17h.01" />
                                                    </svg>
                                                    <h3>Apakah anda yakin?</h3>
                                                    <div class="text-muted">Untuk menghapus pelanggan tersebut</div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="w-100">
                                                        <div class="row">
                                                            <div class="col"><a href="#" class="btn w-100"
                                                                    data-bs-dismiss="modal">
                                                                    Cancel
                                                                </a></div>
                                                            <div class="col"><button type="submit"
                                                                    class="btn btn-danger w-100" data-bs-dismiss="modal">
                                                                    Delete
                                                                </button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="display: none">{{ $aset->created_at }}</td>
                            <td>{{ $aset->ulp }}</td>
                            <td>{{ \Carbon\Carbon::parse($aset->created_at)->format('F Y') }}</td>
                            <td>{{ $aset->kms_jtm }}</td>
                            <td>{{ $aset->kms_jtr }}</td>
                            <td>{{ $aset->jumlah_trafo }}</td>
                            <td>{{ $aset->total_daya_trafo }}</td>
                            <td>{{ $aset->sr }}</td>
                            <td>{{ $aset->jumlah_tiang_tm }}</td>
                            <td>{{ $aset->jumlah_tiang_tr }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center" colspan="4"><a href="/koordinator/map_aset">Total UP3 Grobogan</a></th>
                        <th id="total_kms_jtm"></th>
                        <th id="total_kms_jtr"></th>
                        <th id="total_jumlah_trafo"></th>
                        <th id="total_total_daya_trafo"></th>
                        <th id="total_sr"></th>
                        <th id="total_jumlah_tiang_tm"></th>
                        <th id="total_jumlah_tiang_tr"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="bulanGI">Pilih Bulan:</label>
                        <input type="month" id="bulanGI" class="form-control" placeholder="YYYY-MM">
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button id="filterGI" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
                <div style="overflow-y: auto;">
                    <h2 class="mt-2">Data Peak Trafo GI</h2>
                    <table class="table-bordered tabel-app mt-2 display" id="tabel-gi">
                        <thead class="text-light" style="background:linear-gradient(#780206, #061161)">
                            <tr>
                                <th>GI</th>
                                <th style="display: none">Created At</th>
                                <th>Daya Terpasang</th>
                                <th>Daya Terpakai</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_gi as $gi)
                                @php
                                    if (empty($gi) || empty($gi->gi)) {
                                        continue; // Lewati iterasi jika $gi kosong
                                    }
                                    $highlight = in_array($gi->gi, [
                                        'GI Kedung Ombo',
                                        'GI Sayung',
                                        'GI Purwodadi',
                                        'GI Kudus',
                                        'GI Semen Grobogan',
                                        'GI Mranggen',
                                    ]);
                                @endphp
                                <tr
                                    style="{{ $highlight ? 'background:linear-gradient(#0F2027, #203A43, #2C5364); color:white;' : '' }}">
                                    <td>{{ $gi->gi }}</td>
                                    <td style="display: none">{{ $gi->created_at }}</td>
                                    <td>{{ $gi->daya_terpasang }}</td>
                                    <td>{{ $gi->daya_terpakai }}</td>
                                    <td>{{ number_format($gi->daya_terpasang_terpakai_persen, 0) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="col-lg-3">
                <canvas id="giDayaChart" width="10" height="10"></canvas>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-lg-12">
                {{-- <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="bulanGI">Pilih Bulan:</label>
                        <input type="month" id="bulanGI" class="form-control" placeholder="YYYY-MM">
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button id="filterGI" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div> --}}
                <div style="overflow-y: auto;">
                    <h2 class="mt-2">Laporan Kelengkapan Data Asset dan Data Pelanggan</h2>
                    <form action="/hapusPelangganAPP" method="post">
                        @csrf
                        @method('delete')
                        <a href="#" class="btn btn-danger col-12 mb-2" data-bs-toggle="modal"
                            data-bs-target="#modal-delete-pelanggan">
                            <i class="fa-solid fa-trash fa-lg" style="margin-right: 5px;"></i> Hapus Pelanggan
                        </a>
                        <div class="modal modal-blur fade" id="modal-delete-pelanggan" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    <div class="modal-status bg-danger"></div>
                                    <div class="modal-body text-center py-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                                            <path d="M12 9v4" />
                                            <path d="M12 17h.01" />
                                        </svg>
                                        <h3>Apakah anda yakin?</h3>
                                        <div class="text-muted">Untuk menghapus pelanggan tersebut</div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="w-100">
                                            <div class="row">
                                                <div class="col"><a href="#" class="btn w-100"
                                                        data-bs-dismiss="modal">
                                                        Cancel
                                                    </a></div>
                                                <div class="col"><button type="submit" class="btn btn-danger w-100"
                                                        data-bs-dismiss="modal">
                                                        Delete
                                                    </button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table-bordered tabel-app mt-2 display" id="tabel-kelengkapan-data-asset">
                            <thead class="text-light" style="background:linear-gradient(#780206, #061161)">
                                <tr>
                                    {{-- <th>Tanggal Pasang</th> --}}
                                    <th>
                                        <div class="d-flex justify-content-center">
                                            <div class="form-check">
                                                <input class="form-check-input mt-2" style="position:relative; left:10px;"
                                                    type="checkbox" id="checklist-pelanggan-app"
                                                    onclick="checkAllPelangganAPP()">
                                            </div>
                                        </div>
                                    </th>
                                    <th>ID Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data_pelanggan_app as $app)
                                    @if (!empty($app->id_pelanggan))
                                        <tr>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $app->id }}" id="flexCheckDefault"
                                                            name="checkPelangganAPP[]">
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- <td>{{ $app->tanggal_pasang }}</td> --}}
                                            <td>{{ $app->id_pelanggan }}</td>
                                            <td>{{ $app->nama_pelanggan }}</td>
                                            <td>
                                                <a href="#" data-bs-target="#{{ $app->id }}"
                                                    data-bs-toggle="modal">
                                                    <i class="fa-solid fa-circle-info fa-lg text-primary"></i>
                                                </a>
                                                <div class="modal modal-blur fade" id="{{ $app->id }}"
                                                    tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ $app->nama_pelanggan }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Tanggal Pasang</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->tanggal_pasang }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">ID Pelanggan</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->id_pelanggan }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Nama
                                                                            Pelanggan</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->nama_pelanggan }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Tarif</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->tarif }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Daya</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->daya }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Alamat</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->alamat }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Latitude</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->latitude }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Longitude</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->longitude }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Jenis Meter</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->jenis_meter }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Merk Meter</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->merk_meter }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Tahun Meter</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->tahun_meter }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Nomor Meter</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->nomor_meter }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Merk MCB</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->merk_mcb }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Nomor Segel</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->no_segel }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Nomor Gardu</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->no_gardu }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Tarikan SR ke</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->sr_deret }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Catatan</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->catatan }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-lg-12">
                                                                        <label class="form-label">Nama Petugas</label>
                                                                        <div class="input-group input-group-flat">
                                                                            <input type="text"
                                                                                value="{{ $app->nama_petugas }}"
                                                                                class="form-control" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>
                                        <h3 class="text-center mt-2"><a href="/koordinator/map_aset">Buka MAP ULP
                                                Demak</a>
                                        </h3>
                                    </td>
                                    <td>
                                        <h3 class="text-center mt-2"><a href="/koordinator/map_aset">Buka MAP ULP
                                                Tegowanu</a>
                                        </h3>
                                    </td>
                                    <td>
                                        <h3 class="text-center mt-2"><a href="/koordinator/map_aset">Buka MAP ULP
                                                Purwodadi</a>
                                        </h3>
                                    </td>
                                    <td>
                                        <h3 class="text-center mt-2"><a href="/koordinator/map_aset">Buka MAP ULP
                                                Wirosari</a>
                                        </h3>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
            {{-- <div class="col-lg-3">
                <canvas id="giDayaChart" width="10" height="10"></canvas>
            </div> --}}
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            let table = $('#tabel-aset').DataTable({
                'pageLength': 5,
                'lengthMenu': [10, 20, 50, 100, 200, 500],
                "footerCallback": function(row, data, start, end, display) {
                    let api = this.api();

                    // Fungsi untuk menghitung total
                    let total = function(index) {
                        return api
                            .column(index, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function(a, b) {
                                return parseFloat(a) + parseFloat(b);
                            }, 0).toFixed(2);
                    };

                    $(api.column(4).footer()).html(total(4));
                    $(api.column(5).footer()).html(total(5));
                    $(api.column(6).footer()).html(total(6));
                    $(api.column(7).footer()).html(total(7));
                    $(api.column(8).footer()).html(total(8));
                    $(api.column(9).footer()).html(total(9));
                    $(api.column(10).footer()).html(total(10));
                },
                "order": [
                    [0, "asc"]
                ],
                "columnDefs": [{
                    "targets": 1,
                    "visible": false
                }]
            });

            // Event Filter
            $('#filterAset').on('click', function() {
                let bulanAset = $('#bulanAset').val();

                if (bulanAset) {
                    table.draw();
                } else {
                    alert("Silakan pilih bulan.");
                }
            });

            // Custom Filter untuk Tanggal
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                let createdAt = data[1]; // Index kolom created_at
                let bulanAset = $('#bulanAset').val();

                if (bulanAset) {
                    let date = new Date(createdAt);
                    let start = new Date(bulanAset + "-01"); // Awal bulan yang dipilih

                    return date.getFullYear() === start.getFullYear() && date.getMonth() === start
                        .getMonth();
                }
                return true;
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            let table = $('#tabel-gi').DataTable({
                'pageLength': 19,
                'lengthMenu': [10, 20, 50, 100, 200, 500],
                "footerCallback": function(row, data, start, end, display) {
                    let api = this.api();
                },
                "order": [
                    [0, "desc"]
                ],
                "columnDefs": [{
                    "targets": 1,
                    "visible": false
                }]
            });

            // Event Filter
            $('#filterGI').on('click', function() {
                let bulanAset = $('#bulanGI').val();

                if (bulanGI) {
                    table.draw();
                } else {
                    alert("Silakan pilih bulan.");
                }
            });

            // Custom Filter untuk Tanggal
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                let createdAt = data[1]; // Index kolom created_at
                let bulanGI = $('#bulanGI').val();

                if (bulanGI) {
                    let date = new Date(createdAt);
                    let start = new Date(bulanGI + "-01"); // Awal bulan yang dipilih

                    return date.getFullYear() === start.getFullYear() && date.getMonth() === start
                        .getMonth();
                }
                return true;
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            function template_tabel(nama_tabel) {
                $(nama_tabel).DataTable({
                    'pageLength': 10,
                    'lengthMenu': [10, 25, 50, 100, 200, 500, 2000],
                    'order': [
                        [0, 'asc']
                    ]
                });
            }

            template_tabel('#tabel-kelengkapan-data-asset');
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function checkboxGroup(checklistAllParam, checkboxesParam) {
                var checkboxGroups = [{
                    checklistAll: document.getElementById(checklistAllParam),
                    checkboxes: document.querySelectorAll(checkboxesParam)
                }, ];

                checkboxGroups.forEach(function(group) {
                    group.checklistAll.addEventListener("change", function() {
                        group.checkboxes.forEach(function(checkbox) {
                            checkbox.checked = group.checklistAll.checked;
                        });
                    });
                });
            }
            checkboxGroup("checklist-pelanggan-app", 'input[name="checkPelangganAPP[]"]');
        });
    </script>
@endsection
