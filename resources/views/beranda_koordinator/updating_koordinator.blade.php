@extends('layout/templateberanda_koordinator')
@section('content')
    <div class="container-fluid">
        <form method="post" action="/koordinator/import_excel_data_aset" enctype="multipart/form-data">
            @csrf
            <div class="form-label fs-2">Upload File Excel Manajemen Aset Jaringan</div>
            <input type="file" name="file_data_aset" id="file_data_aset" class="form-control" required />
            <div class="row">
                <button type="submit" class="btn btn-primary mt-2 mb-3 col-lg-6"><i class="fa-solid fa-upload fa-lg"
                        style="margin-right: 5px"></i>Import
                    Excel</button>
                <a href="/file_data_aset/template_recloser_lbs/Data Label.xlsx"
                    class="btn btn-success mt-2 mb-3 col-lg-6"><i class="fa-solid fa-download fa-lg"
                        style="margin-right: 5px"></i>Template
                    Excel</a>
            </div>
        </form>
        <form method="post" action="/koordinator/import_excel_data_gi" enctype="multipart/form-data">
            @csrf
            <div class="form-label fs-2">Upload File Excel Data Peak Trafo GI</div>
            <input type="file" name="file_data_gi" id="file_data_gi" class="form-control" required />
            <div class="row">
                <button type="submit" class="btn btn-primary mt-2 mb-3 col-lg-6"><i class="fa-solid fa-upload fa-lg"
                        style="margin-right: 5px"></i>Import
                    Excel</button>
                <a href="/file_data_gi/template_recloser_lbs/Data Label.xlsx" class="btn btn-success mt-2 mb-3 col-lg-6"><i
                        class="fa-solid fa-download fa-lg" style="margin-right: 5px"></i>Template
                    Excel</a>
            </div>
        </form>
        <form method="post" action="/koordinator/import_excel_kelengkapan_data_aset" enctype="multipart/form-data">
            @csrf
            <div class="form-label fs-2">Upload File Excel Kelengkapan Data Aset</div>
            <input type="file" name="file_kelengkapan_data_aset" id="file_kelengkapan_data_aset" class="form-control" required />
            <div class="row">
                <button type="submit" class="btn btn-primary mt-2 mb-3 col-lg-6"><i class="fa-solid fa-upload fa-lg"
                        style="margin-right: 5px"></i>Import
                    Excel</button>
                <a href="/file_data_gi/template_recloser_lbs/Data Label.xlsx" class="btn btn-success mt-2 mb-3 col-lg-6"><i
                        class="fa-solid fa-download fa-lg" style="margin-right: 5px"></i>Template
                    Excel</a>
            </div>
        </form>
    </div>
@endsection
