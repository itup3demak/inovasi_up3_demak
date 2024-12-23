{{-- test 123 --}}
@extends('layout/templateberanda')
@section('content')
    <div class="container-fluid mt-3">
        @foreach (['success_import_pelanggan', 'success_import_penyulang', 'success_import_section', 'success_import_trafo', 'success_tambah_dataunit', 'success_tambah_wanotif', 'success_hapus_pelanggan', 'success_hapus_trafo', 'success_hapus_unit', 'success_hapus_wanotif', 'success_hapus_datazone', 'success_edit_pelanggan', 'success_edit_trafo', 'success_edit_unit', 'success_edit_wanotif', 'success_edit_datazone', 'success_import_data_pohon', 'success_import_keypoint', 'success_edit_datapohon', 'success_edit_datatrafo2'] as $msg)
            @if (session($msg))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h3>{{ session($msg) }}</h3>
                </div>
            @endif
        @endforeach
        @foreach (['error_import_pelanggan', 'error_import_penyulang', 'error_import_section', 'error_import_trafo', 'error_tambah_dataunit', 'error_tambah_wanotif', 'error_hapus_pelanggan', 'error_hapus_trafo', 'error_hapus_unit', 'error_hapus_wanotif', 'error_hapus_datazone', 'error_edit_pelanggan', 'error_edit_trafo', 'error_edit_unit', 'error_edit_wanotif', 'error_import_data_pohon', 'error_import_keypoint'] as $msg)
            @if (session($msg))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h3>{{ session($msg) }}</h3>
                </div>
            @endif
        @endforeach
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="card border border-warning">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold bg-warning text-light fs-3" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapsePenyulangSection" aria-expanded="false"
                            aria-controls="collapsePenyulangSection">
                            Penyulang & Section
                        </button>
                    </h2>
                    <div id="collapsePenyulangSection" class="accordion-collapse collapse show"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <form method="post" action="/updating/import_excel_penyulangsection"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-label fs-2">Upload File Penyulang</div>
                                <input type="file" name="file_penyulang" class="form-control" required />
                                <div class="form-label mt-2 fs-2">Upload File Section</div>
                                <input type="file" name="file_section" class="form-control" required />
                                <div class="row mt-2">
                                    <button type="submit" class="btn btn-primary mt-1 mb-3 col-lg-4"><i
                                            class="fa-solid fa-upload fa-lg" style="margin-right: 5px"></i>Import
                                        Excel</button>
                                    <a href="file_penyulang/template_penyulang/penyulang dummy.xlsx"
                                        class="btn btn-success mt-1 mb-3 col-lg-4"><i class="fa-solid fa-download fa-lg"
                                            style="margin-right: 5px"></i>Template Excel Penyulang</a>
                                    <a href="file_section/template_section/section dummyy.xlsx"
                                        class="btn btn-secondary mt-1 mb-3 col-lg-4"><i class="fa-solid fa-download fa-lg"
                                            style="margin-right: 5px"></i>Template Excel Section</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border border-info mt-2">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold bg-info text-light fs-3" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapsePelanggan" aria-expanded="false"
                            aria-controls="collapsePelanggan">
                            Data Pelanggan
                        </button>
                    </h2>
                    <div id="collapsePelanggan" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <form method="post" action="/updating/import_excel" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-label fs-2">Upload File Pelanggan</div>
                                <input type="file" name="file" class="form-control" required />
                                <div class="row mt-2">
                                    <button type="submit" class="btn btn-primary mt-1 mb-3 col-lg-4"><i
                                            class="fa-solid fa-upload fa-lg" style="margin-right: 5px"></i>Import Excel
                                    </button>
                                    <a href="/updating/export_excel_pelanggan" class="btn btn-warning mt-1 mb-3 col-lg-4"><i
                                            class="fa-solid fa-file-export fa-lg" style="margin-right: 5px"></i>Export
                                        Excel
                                    </a>
                                    <a href="file_pelanggan/template_pelanggan/Pelanggan TM.xlsx"
                                        class="btn btn-success mt-1 mb-3 col-lg-4"><i class="fa-solid fa-download fa-lg"
                                            style="margin-right: 5px"></i>Template Excel</a>
                                </div>
                            </form>
                            <form action="/updating/hapus_pelanggan" method="post">
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
                                        </div>
                                    </div>
                                </div>
                                <div style="overflow-y: auto;">
                                    <table class="table-bordered display" id="tabel_data_pelanggan">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input mt-2"
                                                                style="position:relative; left:10px;" type="checkbox"
                                                                id="checklist-pelanggan" onclick="checkAllPelanggan()">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>ID Pelanggan</th>
                                                <th>Nama</th>
                                                <th>Alamat</th>
                                                <th>Maps</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data_pelanggan as $s)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $s->id }}" id="flexCheckDefault"
                                                                    name="checkPelanggan[]">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $s->idpel }}</td>
                                                    <td>{{ $s->nama }}</td>
                                                    <td>{{ $s->alamat }}</td>
                                                    <td><a href="{{ $s->maps }}"
                                                            target="_blank">{{ $s->maps }}</a>
                                                    </td>
                                                    <td>
                                                        <a href="#" data-bs-target="#{{ $s->id }}"
                                                            data-bs-toggle="modal">
                                                            <i class="fa-solid fa-circle-info fa-lg text-primary"></i>
                                                        </a>
                                                        <a style="cursor: pointer" class="text-secondary"
                                                            href="/updating/editpelanggan/{{ $s->id }}">
                                                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                                        </a>
                                                        {{-- </form> --}}
                                                        <div class="modal modal-blur fade" id="{{ $s->id }}"
                                                            tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">{{ $s->nama }}</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="mb-3 col-lg-12">
                                                                                <label class="form-label">Nama
                                                                                    Pelanggan</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->nama }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Alamat</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <textarea class="form-control" name="alamat" rows="5" readonly>{{ $s->alamat }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-12">
                                                                                <label class="form-label">No HP
                                                                                    StakeHolder</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->nohp_stakeholder }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-12">
                                                                                <label class="form-label">No HP PIC
                                                                                    Lapangan</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->nohp_piclapangan }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Latitude</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->latitude }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label
                                                                                    class="form-label">Longtitude</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->longtitude }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Unit ULP</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <?php if ($s->unitulp == 52550) : ?>
                                                                                    <input type="text"
                                                                                        value="UP3 Demak"
                                                                                        class="form-control" readonly>
                                                                                    <?php elseif($s->unitulp == 52551) : ?>
                                                                                    <input type="text"
                                                                                        value="ULP Demak"
                                                                                        class="form-control" readonly>
                                                                                    <?php elseif($s->unitulp == 52552) : ?>
                                                                                    <input type="text"
                                                                                        value="ULP Tegowanu"
                                                                                        class="form-control" readonly>
                                                                                    <?php elseif($s->unitulp == 52553) : ?>
                                                                                    <input type="text"
                                                                                        value="ULP Purwodadi"
                                                                                        class="form-control" readonly>
                                                                                    <?php elseif($s->unitulp == 52554) : ?>
                                                                                    <input type="text"
                                                                                        value="ULP Wirosari"
                                                                                        class="form-control" readonly>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Tarif</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->tarif }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Daya</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->daya }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">KOGOL</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->kogol }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">fakmkwh</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->fakmkwh }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">rpbp</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->rpbp }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">rpujl</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->rpujl }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">nomor_kwh</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->nomor_kwh }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">penyulang</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->penyulang }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-12">
                                                                                <label
                                                                                    class="form-label">nama_section</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <textarea class="form-control" name="nama_section" rows="3" readonly>{{ $s->nama_section }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-12">
                                                                                <label class="form-label">Kali
                                                                                    Padam</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    @if ($s->entriPadam)
                                                                                        <input type="text"
                                                                                            value="{{ $s->entriPadam->kalipadam }}"
                                                                                            class="form-control" readonly>
                                                                                    @else
                                                                                        <input type="text"
                                                                                            value="{{ 0 }}"
                                                                                            class="form-control" readonly>
                                                                                    @endif
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2 border border-success">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold bg-success text-light fs-3" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseTrafo" aria-expanded="false"
                            aria-controls="collapseTrafo">
                            Data Trafo
                        </button>
                    </h2>
                    <div id="collapseTrafo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <form method="post" action="/updating/import_excel_trafo" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-label fs-2">Upload File Trafo</div>
                                <input type="file" name="file" class="form-control" required />
                                <div class="row mt-2">
                                    <button type="submit" class="btn btn-primary mt-2 mb-2 col-lg-6"><i
                                            class="fa-solid fa-upload fa-lg" style="margin-right: 5px"></i>Import
                                        Excel</button>
                                    <a href="file_trafo/template_trafo/Data Trafo.xlsx"
                                        class="btn btn-success mt-2 mb-2 col-lg-6"><i class="fa-solid fa-download fa-lg"
                                            style="margin-right: 5px"></i>Template
                                        Excel</a>
                                </div>
                            </form>
                            <form action="/updating/hapus_trafo" method="post">
                                @csrf
                                @method('delete')
                                <a href="#" class="btn btn-danger col-12 mt-2 mb-2 button-delete-trafo"
                                    data-bs-toggle="modal" data-bs-target="#modal-delete-trafo">
                                    <i class="fa-solid fa-trash fa-lg" style="margin-right: 5px;"></i> Hapus Trafo
                                </a>
                                <div class="modal modal-blur fade" id="modal-delete-trafo" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                        <div class="modal-content">
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
                                                <div class="text-muted">Untuk menghapus trafo tersebut</div>
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
                                        </div>
                                    </div>
                                </div>
                                <div style="overflow-y: auto;">
                                    <table class="table-bordered display" id="tabel_data_trafo">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input mt-2"
                                                                style="position:relative; left:10px;" type="checkbox"
                                                                id="checklist-trafo" onclick="checkAllTrafo()">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>Unit Layanan</th>
                                                <th>Penyulang</th>
                                                <th>No Tiang</th>
                                                <th>Lokasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data_trafo as $s)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $s->id }}" id="flexCheckDefault"
                                                                    name="checkTrafo[]">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $s->unit_layanan }}</td>
                                                    <td>{{ $s->penyulang }}</td>
                                                    <td>{{ $s->no_tiang }}</td>
                                                    <td>{{ $s->lokasi }}</td>
                                                    <td>
                                                        <a href="#" data-bs-target="#trafo-{{ $s->id }}"
                                                            data-bs-toggle="modal">
                                                            <i class="fa-solid fa-circle-info fa-lg text-primary"></i>
                                                        </a>
                                                        <a style="cursor: pointer" class="text-secondary"
                                                            href="/updating/edittrafo/{{ $s->id }}">
                                                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                                        </a>
                                                        {{-- </form> --}}
                                                        <div class="modal modal-blur fade" id="trafo-{{ $s->id }}"
                                                            tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">{{ $s->penyulang }}</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Unit
                                                                                    Layanan</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->unit_layanan }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Additional fields -->
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Penyulang</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->penyulang }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Nomor
                                                                                    Tiang</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->no_tiang }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Daya</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->daya }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Merk</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->merk }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Beban X1</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->beban_X1 }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Beban X2</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->beban_X2 }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Beban Xo</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->beban_Xo }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-4">
                                                                                <label class="form-label">Lokasi</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->lokasi }}"
                                                                                        class="form-control" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-lg-12">
                                                                                <label class="form-label">Koordinat</label>
                                                                                <div class="input-group input-group-flat">
                                                                                    <input type="text"
                                                                                        value="{{ $s->latitude }}{{ $s->longitude }}"
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="card mt-2 border border-secondary">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold bg-secondary text-light fs-3" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseDataUnit" aria-expanded="false"
                            aria-controls="collapseDataUnit">
                            Data Unit
                        </button>
                    </h2>
                    <div id="collapseDataUnit" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <button type="button" class="btn btn-info mb-3 col-12" data-bs-toggle="modal"
                                data-bs-target="#modalTambahDataUnit"><i class="fa-solid fa-circle-plus fa-lg"
                                    style="margin-right: 5px;"></i>
                                Tambah Data Unit
                            </button>
                            <div class="modal fade" id="modalTambahDataUnit" tabindex="-1"
                                aria-labelledby="modalTambahDataUnitLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="/updating/proses_tambah_dataunit" method="post">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-3" id="modalTambahDataUnitLabel">Tambah Data
                                                    Unit
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Unit</label>
                                                    <div class="input-group input-group-flat">
                                                        <input type="hidden" name="idunit" id="idunit">
                                                        <select class="form-control" name="unit" id="unit">
                                                            <option selected>--- Pilih Unit---
                                                            </option>
                                                            <option value="ULP Demak">
                                                                ULP Demak</option>
                                                            <option value="ULP Tegowanu">
                                                                ULP Tegowanu</option>
                                                            <option value="ULP Purwodadi">
                                                                ULP Purwodadi
                                                            </option>
                                                            <option value="ULP Wirosari">
                                                                ULP Wirosari</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nomor MULP</label>
                                                    <div class="input-group input-group-flat">
                                                        <input type="text" class="form-control" name="no_mulp"
                                                            id="no_mulp" inputmode="numeric" pattern="[0-9]*">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nomor TL Teknik</label>
                                                    <div class="input-group input-group-flat">
                                                        <input type="text" class="form-control" name="no_tlteknik"
                                                            id="no_tlteknik" inputmode="numeric" pattern="[0-9]*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <form action="/updating/hapus_dataunit" method="post">
                                @csrf
                                @method('delete')
                                <a href="#" class="btn btn-danger col-12 mb-2" data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-dataunit">
                                    <i class="fa-solid fa-trash fa-lg" style="margin-right: 5px;"></i> Hapus Data Unit
                                </a>
                                <div class="modal modal-blur fade" id="modal-delete-dataunit" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                        <div class="modal-content">
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
                                                <div class="text-muted">Untuk menghapus dataunit tersebut</div>
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
                                        </div>
                                    </div>
                                </div>
                                <div style="overflow-y: auto;">
                                    <table class="table-bordered display" id="tabel_data_unit">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input mt-2"
                                                                style="position:relative; left:10px;" type="checkbox"
                                                                id="checklist-dataunit" onclick="checkAllDataUnit()">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>ID Unit</th>
                                                <th>Unit</th>
                                                <th>No HP MULP</th>
                                                <th>No HP TLTeknik</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($data_unit as $unit)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $unit->id }}" id="flexCheckDefault"
                                                                    name="checkDataUnit[]">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $unit->idunit }}</td>
                                                    <td>{{ $unit->unit }}</td>
                                                    <td>{{ $unit->no_mulp }}</td>
                                                    <td>{{ $unit->no_tlteknik }}</td>
                                                    <td>
                                                        <a style="cursor: pointer" class="text-secondary"
                                                            href="/updating/editdataunit/{{ $unit->id }}">
                                                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2 border border-danger">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold bg-danger text-light fs-3" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseWANotif" aria-expanded="false"
                            aria-controls="collapseWANotif">
                            WA Notif
                        </button>
                    </h2>
                    <div id="collapseWANotif" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <button type="button" class="btn btn-info mb-3 col-12" data-bs-toggle="modal"
                                data-bs-target="#modalTambahWANotif"><i class="fa-solid fa-circle-plus fa-lg"
                                    style="margin-right: 5px;"></i>
                                Tambah WA Notif
                            </button>
                            <div class="modal fade" id="modalTambahWANotif" tabindex="-1"
                                aria-labelledby="modalTambahWANotifLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="/updating/proses_tambah_wanotif" method="post">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-3" id="modalTambahWANotifLabel">Tambah WA Notif
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-4">
                                                    <label class="form-label">ID Serial</label>
                                                    <div class="input-group input-group-flat">
                                                        <input class="form-control" name="idserial" id="idserial"
                                                            type="text" inputmode="numeric" pattern="[0-9]*">
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label">ID Pelanggan</label>
                                                    <div class="input-group input-group-flat">
                                                        <input class="form-control" name="idpel" id="idpel"
                                                            type="text" inputmode="numeric" pattern="[0-9]*">
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label">ID Unit</label>
                                                    <div class="input-group input-group-flat">
                                                        <select class="form-control" name="idunit" id="idunit">
                                                            <option selected disabled>--- Pilih ID Unit ---</option>
                                                            <option value="52551">52551</option>
                                                            <option value="52552">52552</option>
                                                            <option value="52553">52553</option>
                                                            <option value="52554">52554</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <form action="/updating/hapus_wanotif" method="post">
                                @csrf
                                @method('delete')
                                <a href="#" class="btn btn-danger col-12 mb-2" data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-wanotif">
                                    <i class="fa-solid fa-trash fa-lg" style="margin-right: 5px;"></i> Hapus WA Notif
                                </a>
                                <div class="modal modal-blur fade" id="modal-delete-wanotif" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                        <div class="modal-content">
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
                                                <div class="text-muted">Untuk menghapus wanotif tersebut</div>
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
                                        </div>
                                    </div>
                                </div>
                                <div style="overflow-y: auto;">
                                    <table class="table-bordered display" id="tabel_data_wanotif">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input mt-2"
                                                                style="position:relative; left:10px;" type="checkbox"
                                                                id="checklist-wanotif" onclick="checkAllWANotif()">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>ID Serial</th>
                                                <th>ID Pel</th>
                                                <th>ID Unit</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($data_wanotif as $wanotif)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $wanotif->id }}" id="flexCheckDefault"
                                                                    name="checkWANotif[]">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $wanotif->idserial }}</td>
                                                    <td>{{ $wanotif->idpel }}</td>
                                                    <td>{{ $wanotif->idunit }}</td>
                                                    <td>
                                                        <a style="cursor: pointer" class="text-secondary"
                                                            href="/updating/editwanotif/{{ $wanotif->id }}">
                                                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="card mt-2 border">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold bg-primary text-light fs-3" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseDataZone" aria-expanded="false"
                            aria-controls="collapseDataZone">
                            Data Zone
                        </button>
                    </h2>
                    <div id="collapseDataZone" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <form method="post" action="/updating/import_excel_datazone" enctype="multipart/form-data">
                                @csrf
                                <div class="form-label fs-2">Upload File Data Zone</div>
                                <input type="file" name="file_datazone" id="file_datazone" class="form-control"
                                    required />
                                <div class="row">
                                    <button type="submit" class="btn btn-primary mt-2 mb-3 col-lg-6"><i
                                            class="fa-solid fa-upload fa-lg" style="margin-right: 5px"></i>Import
                                        Excel</button>
                                    <a href="/file_datazone/template_datazone/data_zone_non_reclose_PWI_edit.xlsx"
                                        class="btn btn-success mt-2 mb-3 col-lg-6"><i class="fa-solid fa-download fa-lg"
                                            style="margin-right: 5px"></i>Template
                                        Excel</a>
                                </div>
                            </form>
                            <form action="/updating/hapus_datazone" method="post">
                                @csrf
                                @method('delete')
                                <a href="#" class="btn btn-danger col-12 mb-2" data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-datazone">
                                    <i class="fa-solid fa-trash fa-lg" style="margin-right: 5px;"></i> Hapus Data Zone
                                </a>
                                <div class="modal modal-blur fade" id="modal-delete-datazone" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                        <div class="modal-content">
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
                                                <div class="text-muted">Untuk menghapus datazone tersebut</div>
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
                                        </div>
                                    </div>
                                </div>
                                <div style="overflow-y: auto;">
                                    <table class="table-bordered display" id="tabel_data_zone">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input mt-2"
                                                                style="position:relative; left:10px;" type="checkbox"
                                                                id="checklist-datazone" onclick="checkAllDataZone()">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>Feeder</th>
                                                <th>Keypoint</th>
                                                <th>Jarak</th>
                                                <th>Latitude</th>
                                                <th>Longitude</th>
                                                <th>Google Maps</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($data_zone as $zone)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $zone->id }}" id="flexCheckDefault"
                                                                    name="checkDataZone[]">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $zone->feeder }}</td>
                                                    <td>{{ $zone->keypoint }}</td>
                                                    <td>{{ $zone->jarak }}</td>
                                                    <td>{{ $zone->latitude }}</td>
                                                    <td>{{ $zone->longitude }}</td>
                                                    <td><a href="{{ $zone->google_maps }}"
                                                            target="_blank">{{ $zone->google_maps }}</a></td>
                                                    <td>
                                                        <a style="cursor: pointer" class="text-secondary"
                                                            href="/updating/editdatazone/{{ $zone->id }}">
                                                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2 border">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold bg-dark text-light fs-3" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseDataPohon" aria-expanded="false"
                            aria-controls="collapseDataPohon">
                            Data Pohon
                        </button>
                    </h2>
                    <div id="collapseDataPohon" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <form action="/updating/import_excel_datapohon" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="form-label fs-2">Upload File Data Pohon</div>
                                <input type="file" name="file_datapohon" id="file_datapohon" class="form-control"
                                    required />
                                <div class="row">
                                    <button type="submit" id="btn-upload" class="btn btn-primary mt-2 mb-3 col-lg-6">
                                        <i class="fa-solid fa-upload fa-lg" style="margin-right: 5px"></i>Import Excel
                                    </button>
                                    <a href="/file_datapohon/template_datapohon/data_peta_pohon.xlsx"
                                        class="btn btn-success mt-2 mb-3 col-lg-6">
                                        <i class="fa-solid fa-download fa-lg" style="margin-right: 5px"></i>Template Excel
                                    </a>
                                </div>
                            </form>
                            <form action="/updating/hapus_datapohon" method="post">
                                @csrf
                                @method('delete')
                                <a href="#" class="btn btn-danger col-12 mb-2" data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-datapohon">
                                    <i class="fa-solid fa-trash fa-lg" style="margin-right: 5px;"></i> Hapus Data Pohon
                                </a>
                                <div class="modal modal-blur fade" id="modal-delete-datapohon" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                        <div class="modal-content">
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
                                                <div class="text-muted">Untuk menghapus datapohon tersebut</div>
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
                                        </div>
                                    </div>
                                </div>
                                <div style="overflow-y: auto;">
                                    <table class="table-bordered display" id="tabel_data_pohon">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input mt-2"
                                                                style="position:relative; left:10px;" type="checkbox"
                                                                id="checklist-datapohon" onclick="checkAllDataPohon()">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>No Tiang Section</th>
                                                <th>Perlu Rabas</th>
                                                <th>Latitude</th>
                                                <th>Longitude</th>
                                                <th>Rayon</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_pohon as $pohon)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $pohon->id }}" id="flexCheckDefault"
                                                                    name="checkDataPohon[]">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $pohon->tiang_section }}</td>
                                                    <td>{{ $pohon->perlu_rabas }}</td>
                                                    <td>{{ $pohon->latitude }}</td>
                                                    <td>{{ $pohon->longitude }}</td>
                                                    <td>{{ $pohon->rayon }}</td>
                                                    <td>
                                                        <a style="cursor: pointer" class="text-secondary"
                                                            href="/updating/editdatapohon/{{ $pohon->id }}">
                                                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2 border">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold bg-pink text-light fs-3" type="button"
                            data-bs-toggle="collapse" data-bs-target="#trafo25kVa50kVa" aria-expanded="false"
                            aria-controls="trafo25kVa50kVa">
                            Trafo 25kVa & 50 kVa
                        </button>
                    </h2>
                    <div id="trafo25kVa50kVa" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <form method="post" action="/updating/import_excel_datatrafo" enctype="multipart/form-data">
                                @csrf
                                <div class="form-label fs-2">Upload File Data Trafo</div>
                                <input type="file" name="file_datatrafo" id="file_datatrafo" class="form-control"
                                    required />
                                <div class="row">
                                    <button type="submit" class="btn btn-primary mt-2 mb-3 col-lg-6"><i
                                            class="fa-solid fa-upload fa-lg" style="margin-right: 5px"></i>Import
                                        Excel</button>
                                    <a href="/file_datapohon/template_datazone/data_zone_non_reclose_PWI_edit.xlsx"
                                        class="btn btn-success mt-2 mb-3 col-lg-6"><i class="fa-solid fa-download fa-lg"
                                            style="margin-right: 5px"></i>Template
                                        Excel</a>
                                </div>
                            </form>
                            <form action="/updating/hapus_datapohon" method="post">
                                @csrf
                                @method('delete')
                                <a href="#" class="btn btn-danger col-12 mb-2" data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-datapohon">
                                    <i class="fa-solid fa-trash fa-lg" style="margin-right: 5px;"></i> Hapus Data Zone
                                </a>
                                <div class="modal modal-blur fade" id="modal-delete-datapohon" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                        <div class="modal-content">
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
                                                <div class="text-muted">Untuk menghapus datapohon tersebut</div>
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
                                        </div>
                                    </div>
                                </div>
                                <div style="overflow-y: auto;">
                                    <table class="table-bordered display" id="tabel_data_trafo2">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input mt-2"
                                                                style="position:relative; left:10px;" type="checkbox"
                                                                id="checklist-datapohon" onclick="checkAllDataPohon()">
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>Rayon</th>
                                                <th>Nomor Tiang</th>
                                                <th>Nomor Gardu</th>
                                                <th>x1</th>
                                                <th>x2</th>
                                                <th>n</th>
                                                <th>perhitungan_beban</th>
                                                <th>klasifikasi_beban</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_trafo2 as $trafo)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $trafo->id }}" id="flexCheckDefault"
                                                                    name="checkDataPohon[]">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $trafo->rayon }}</td>
                                                    <td>{{ $trafo->nomor_tiang }}</td>
                                                    <td>{{ $trafo->nomor_gardu }}</td>
                                                    <td>{{ $trafo->x1 }}</td>
                                                    <td>{{ $trafo->x2 }}</td>
                                                    <td>{{ $trafo->n }}</td>
                                                    <td>{{ $trafo->perhitungan_beban }}</td>
                                                    <td>{{ $trafo->klasifikasi_beban }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            function template_tabel(nama_tabel) {
                $(nama_tabel).DataTable({
                    'pageLength': 10,
                    'lengthMenu': [10, 25, 50, 100, 200, 500],
                });
            }

            template_tabel('#tabel_data_pelanggan');
            template_tabel('#tabel_data_trafo');
            template_tabel('#tabel_data_unit');
            template_tabel('#tabel_data_zone');
            template_tabel('#tabel_data_pohon');
            template_tabel('#tabel_data_trafo2');
            template_tabel('#tabel_data_wanotif');
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
            checkboxGroup("checklist-pelanggan", 'input[name="checkPelanggan[]"]');
            checkboxGroup("checklist-trafo", 'input[name="checkTrafo[]"]');
            checkboxGroup("checklist-wanotif", 'input[name="checkWANotif[]"]');
            checkboxGroup("checklist-datazone", 'input[name="checkDataZone[]"]');
            checkboxGroup("checklist-datapohon", 'input[name="checkDataPohon[]"]');
            checkboxGroup("checklist-dataunit", 'input[name="checkDataUnit[]"]');
        });
    </script>
    <script>
        document.getElementById('unit').addEventListener('change', function() {
            var selectedUnit = this.value;
            var idunit = document.getElementById('idunit');

            if (selectedUnit == 'ULP Demak') {
                idunit.value = '52551'
            }
            if (selectedUnit == 'ULP Tegowanu') {
                idunit.value = '52552'
            }
            if (selectedUnit == 'ULP Purwodadi') {
                idunit.value = '52553'
            }
            if (selectedUnit == 'ULP Wirosari') {
                idunit.value = '52554'
            }
        })
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btn-upload').on('click', function() {
                let formData = new FormData($('#form-upload-datapohon')[0]);
                $('#status-upload').html('<span class="text-info">Uploading...</span>');

                $.ajax({
                    url: '/updating/import_excel_datapohon',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#status-upload').html('<span class="text-success">' + response
                            .message + '</span>');
                    },
                    error: function(xhr, status, error) {
                        $('#status-upload').html('<span class="text-danger">Error: ' + xhr
                            .responseText + '</span>');
                    }
                });
            });
        });
    </script>
@endsection
