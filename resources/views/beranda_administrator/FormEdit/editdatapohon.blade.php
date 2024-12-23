@extends('layout/templateberanda')
@section('content')
    <div class="container-fluid mt-5">
        <div class="card shadow-lg border-0 rounded">
            <div class="card-header bg-dark text-white text-center rounded-top">
                <h3 class="mb-0">Edit Data Pohon</h3>
            </div>
            <div class="card-body p-4">
                <form action="/updating/edit_datapohon/{{ $datapohon->id }}" method="post">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $datapohon->id }}">
                    <div class="mb-3">
                        <label class="form-label">Tiang Section</label>
                        <div class="input-group input-group-flat">
                            <input type="text" class="form-control" name="tiang_section" id="tiang_section"
                                value="{{ $datapohon->tiang_section }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Perlu Rabas</label>
                        <div class="input-group input-group-flat">
                            <input type="text" class="form-control" name="perlu_rabas" id="perlu_rabas"
                                value="{{ $datapohon->perlu_rabas }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Latitude</label>
                        <div class="input-group input-group-flat">
                            <input type="text" class="form-control" name="latitude" id="latitude"
                                value="{{ $datapohon->latitude }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Longitude</label>
                        <div class="input-group input-group-flat">
                            <input type="text" class="form-control" name="longitude" id="longitude"
                                value="{{ $datapohon->longitude }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rayon</label>
                        <div class="input-group input-group-flat">
                            <input type="text" class="form-control" name="rayon" id="rayon"
                                value="{{ $datapohon->rayon }}">
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-block" type="submit"><i
                                class="fa-solid fa-right-to-bracket fa-lg" style="margin-right: 5px;"></i> Submit</button>
                        <a href="/updating" class="btn btn-secondary"><i class="fa-solid fa-left-long fa-lg"
                                style="margin-right: 5px;"></i> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
