@extends('layout/templateberanda')
@section('content')
    <div class="container-fluid">
        <div class="col-lg-12 mt-2">
            @if (session('success_nyala'))
                <div class="alert alert-success">
                    {{ session('success_nyala') }}
                </div>
            @endif
            @if (session('success_tambah'))
                <div class="alert alert-success">
                    {{ session('success_tambah') }}
                </div>
            @endif
            @if (session('error_tambah'))
                <div class="alert alert-danger">
                    {{ session('error_tambah') }}
                </div>
            @endif
            @if (session('error_nyala'))
                <div class="alert alert-danger">
                    {{ session('error_nyala') }}
                </div>
            @endif
            <div class="card p-3">
                <h2>Data Padam Saat Ini</h2>
                <form action="/transaksipadam/edit_status_padam" method="post">
                    @csrf
                    <input type="hidden" value="Menyala" name="status" id="status">
                    <a href="#" class="btn btn-success col-12 mb-3" data-bs-toggle="modal"
                        data-bs-target="#modal-report"><i class="fa-solid fa-power-off fa-lg"
                            style="margin-right: 5px;"></i>
                        Hidupkan
                    </a>
                    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Jam Nyala</label>
                                                <input type="datetime-local"
                                                    class="form-control @error('jam_nyala') is-invalid @enderror"
                                                    name="jam_nyala" id="jam_nyala" value="{{ old('jam_nyala') }}">
                                                @error('jam_nyala')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Penyebab Fix</label>
                                                <textarea class="form-control @error('penyebab_fix') is-invalid @enderror" rows="3" name="penyebab_fix"
                                                    id="penyebab_fix">{{ old('penyebab_fix') }}</textarea>
                                                @error('penyebab_fix')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
                                    <button type="submit" class="btn btn-success ms-auto">
                                        <i class="fa-solid fa-power-off" style="margin-right: 5px;"></i> Hidupkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-vcenter table-bordered table-hover" id="tabel_data_padam">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="5%">
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check">
                                            <input class="form-check-input mt-2" style="position:relative; left:10px;"
                                                type="checkbox" id="checklist-padam">
                                        </div>
                                    </div>
                                </th>
                                <th>Penyulang</th>
                                <th>Section</th>
                                <th>Nomor Tiang</th>
                                <th>Penyebab Padam</th>
                                <th>Jam Padam</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($data_padam as $s)
                                @if ($s->status == 'Padam')
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $s->id }}" id="flexCheckDefault" name="check[]">
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $s->penyulang }}</td>
                                        <td>{{ $s->section }}</td>
                                        <td>
                                            @if ($s->nomorTiang)
                                                {{ $s->nomorTiang->nama_section }}
                                            @else
                                                {{ 0 }}
                                            @endif
                                        </td>
                                        <td>{{ $s->penyebab_padam }}</td>
                                        <td>{{ $s->jam_padam }}</td>
                                        <td>{{ $s->keterangan }}</td>
                                        <td>{{ $s->status }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="card p-3 mb-3 mt-3">
                <h2>Data Pegawai</h2>
                <div class="row">
                    <a href="/transaksiaktif/export_pelanggan_padam" class="btn btn-warning mb-3 m-1 col-lg-2">
                        <i class="fa-solid fa-user-plus fa-lg" style="margin-right: 5px"></i> Tambah Pegawai
                    </a>
                </div>
                <table class="table table-vcenter table-bordered table-hover" id="tabel_data_pegawai" style="width: 100%">
                    <thead>
                        <tr>
                            <th width="2%">
                                <div class="d-flex justify-content-center">
                                    <div class="form-check">
                                        <input class="form-check-input mt-2" style="position:relative; left:10px;"
                                            type="checkbox" id="checklist-whatsapp" onclick="checkAll()">
                                    </div>
                                </div>
                            </th>
                            <th width="26%">Nama Pegawai</th>
                            <th width="30%">Jabatan Pegawai</th>
                            <th width="40%">Unit Pegawai</th>
                            <th width="40%">Nomor Telepon Pegawai</th>
                            <th width="2%">Aksi</th>
                            <th width="0%" style="display:none;">Nomor HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_pegawai as $pegawai)
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check">
                                            {{-- <input class="form-check-input" type="checkbox"
                                                value="{{ $pegawai->idpel }}" id="flexCheckDefault"
                                                name="checkWhatsapp[]" data-nomorhp="{{ $pegawai->nohp_stakeholder }}"
                                                data-penyebab_padam="{{ $pegawai->penyebab_padam }}"
                                                data-keterangan_padam="{{ $pegawai->keterangan }}"> --}}
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $pegawai->nama_pegawai }}</td>
                                <td>{{ $pegawai->jabatan_pegawai }}</td>
                                <td>{{ $pegawai->unit_pegawai }}</td>
                                <td>{{ $pegawai->nomortelepon_pegawai }}</td>
                                <td>
                                    {{-- @php
                                        $pesanWhatsapp = urlencode("Halo, saya rizki. Untuk saat ini mengalami $pegawai->penyebab_padam karena $pegawai->keterangan");
                                    @endphp
                                    <a href="https://wa.me/{{ $pegawai->nohp_stakeholder }}?text={{ $pesanWhatsapp }}"
                                        target="_blank">
                                        <i class="fa-brands fa-whatsapp fa-lg text-success"></i>
                                    </a> --}}
                                </td>
                                <td style="display:none;">{{ $pegawai->nohp_stakeholder }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h2>Pelanggan Padam</h2>
                <div class="row">
                    <a href="/transaksiaktif/export_pelanggan_padam" class="btn btn-warning mb-3 m-1 col-lg-2">
                        <i class="fa-solid fa-download fa-lg" style="margin-right: 5px"></i>Export Excel (xlsx)
                    </a>
                    <a href="/transaksiaktif/export_pelanggan_padam_csv" class="btn btn-warning mb-3 m-1 col-lg-2">
                        <i class="fa-solid fa-download fa-lg" style="margin-right: 5px"></i>Export Excel (csv)
                    </a>
                    <button id="kirimWhatsapp" onclick="kirimWhatsapp()" class="btn btn-success mb-3 m-1 col-lg-2">
                        <i class="fa-brands fa-whatsapp fa-lg" style="margin-right: 5px;"></i>Kirim Whatsapp
                    </button>
                </div>
                <table class="table table-vcenter table-bordered table-hover" id="tabel_rekap_pelanggan"
                    style="width: 100%">
                    <thead>
                        <tr>
                            <th width="2%">
                                <div class="d-flex justify-content-center">
                                    <div class="form-check">
                                        <input class="form-check-input mt-2" style="position:relative; left:10px;"
                                            type="checkbox" id="checklist-whatsapp" onclick="checkAll()">
                                    </div>
                                </div>
                            </th>
                            <th width="26%">Nomor Telepon</th>
                            <th width="30%">Nama Pelanggan</th>
                            <th width="40%">Alamat</th>
                            <th width="2%">Aksi</th>
                            <th width="0%" style="display:none;">Nomor HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekap_pelanggan as $item_rekap)
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ $item_rekap->idpel }}" id="flexCheckDefault"
                                                name="checkWhatsapp[]" data-nomorhp="{{ $item_rekap->nohp_stakeholder }}"
                                                data-penyebab_padam="{{ $item_rekap->penyebab_padam }}"
                                                data-keterangan_padam="{{ $item_rekap->keterangan }}">
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item_rekap->nohp_stakeholder }}</td>
                                <td>{{ $item_rekap->nama }}</td>
                                <td>{{ $item_rekap->alamat }}</td>
                                <td>
                                    @php
                                        $pesanWhatsapp = urlencode("Halo, saya rizki. Untuk saat ini mengalami $item_rekap->penyebab_padam karena $item_rekap->keterangan");
                                    @endphp
                                    <a href="https://wa.me/{{ $item_rekap->nohp_stakeholder }}?text={{ $pesanWhatsapp }}"
                                        target="_blank">
                                        <i class="fa-brands fa-whatsapp fa-lg text-success"></i>
                                    </a>
                                </td>
                                <td style="display:none;">{{ $item_rekap->nohp_stakeholder }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function checkAll() {
            var checklistWhatsapp = document.getElementById('checklist-whatsapp');
            var checkboxes = document.getElementsByName('checkWhatsapp[]');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = checklistWhatsapp.checked;
            });
        }

        function kirimWhatsapp() {
            var checkboxes = document.querySelectorAll('input[name="checkWhatsapp[]"]:checked');

            checkboxes.forEach(function(checkbox) {
                var nomorhp = checkbox.getAttribute('data-nomorhp');
                var penyebab_padam = checkbox.getAttribute('data-penyebab_padam');
                var keterangan_padam = checkbox.getAttribute('data-keterangan_padam');
                var pesanWhatsapp = encodeURI("Halo, saya rizki. Untuk saat ini mengalami " + penyebab_padam +
                    " karena " + keterangan_padam);
                var whatsappLink = 'https://wa.me/' + nomorhp + '?text=' + pesanWhatsapp;
                window.open(whatsappLink, '_blank');
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var checkboxGroups = [{
                checklistAll: document.getElementById("checklist-padam"),
                checkboxes: document.querySelectorAll('input[name="check[]"]')
            }, ];

            checkboxGroups.forEach(function(group) {
                group.checklistAll.addEventListener("change", function() {
                    group.checkboxes.forEach(function(checkbox) {
                        checkbox.checked = group.checklistAll.checked;
                    });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#tabel_data_padam').DataTable({
                scrollX: true,
                'pageLength': 500,
                'lengthMenu': [10, 25, 50, 100, 200, 500],
            });
        });
        $(document).ready(function() {
            $('#tabel_rekap_pelanggan').DataTable({
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: true,
                'pageLength': 500,
                'lengthMenu': [10, 25, 50, 100, 200, 500],
            });
        });
        $(document).ready(function() {
            $('#tabel_data_pegawai').DataTable({
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: true,
                'pageLength': 500,
                'lengthMenu': [10, 25, 50, 100, 200, 500],
            })
        })
    </script>
@endsection
