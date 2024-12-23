@extends('layout/templateberanda')
@section('content')
    <div class="container-fluid mt-5">
        <div class="card shadow-lg border-0 rounded">
            <div class="card-header bg-success text-white text-center rounded-top">
                <h3 class="mb-0">Edit Trafo</h3>
            </div>
            <div class="card-body p-4">
                <form action="/updating/edit_trafo/{{ $trafo->id }}" method="post">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $trafo->id }}">
                    <div class="mb-3">
                        <label class="form-label">Unit Layanan</label>
                        <div class="input-group input-group-flat">
                            <select name="unit_layanan" id="unit_layanan"
                                class="form-control @error('unit_layanan') is-invalid @enderror">
                                <option value="Demak" {{ $trafo->unit_layanan == 'Demak' ? 'selected' : '' }}>
                                    Demak</option>
                                <option value="Tegowanu" {{ $trafo->unit_layanan == 'Tegowanu' ? 'selected' : '' }}>
                                    Tegowanu
                                </option>
                                <option value="Purwodadi" {{ $trafo->unit_layanan == 'Purwodadi' ? 'selected' : '' }}>
                                    Purwodadi
                                </option>
                                <option value="Wirosari" {{ $trafo->unit_layanan == 'Wirosari' ? 'selected' : '' }}>
                                    Wirosari
                                </option>
                            </select>
                            @error('unit_layanan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penyulang</label>
                        <div class="input-group input-group-flat">
                            <input type="text" name="penyulang" id="penyulang" value="{{ $trafo->penyulang }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Tiang</label>
                        <div class="input-group input-group-flat">
                            <input type="text" name="no_tiang" id="no_tiang" value="{{ $trafo->no_tiang }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Daya</label>
                        <div class="input-group input-group-flat">
                            <input inputmode="numeric" pattern="[0-9]*" type="text" name="daya" id="daya" value="{{ $trafo->daya }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Merk</label>
                        <div class="input-group input-group-flat">
                            <input type="text" name="merk" id="merk" value="{{ $trafo->merk }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Beban X1</label>
                        <div class="input-group input-group-flat">
                            <input inputmode="numeric" pattern="[0-9]*" type="text" name="beban_X1" id="beban_X1" value="{{ $trafo->beban_X1 }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Beban X2</label>
                        <div class="input-group input-group-flat">
                            <input inputmode="numeric" pattern="[0-9]*" type="text" name="beban_X2" id="beban_X2" value="{{ $trafo->beban_X2 }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Beban Xo</label>
                        <div inputmode="numeric" pattern="[0-9]*" class="input-group input-group-flat">
                            <input type="text" name="beban_Xo" id="beban_Xo" value="{{ $trafo->beban_Xo }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <div class="input-group input-group-flat">
                            <input type="text" name="lokasi" id="lokasi" value="{{ $trafo->lokasi }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">penyebab</label>
                        <div class="input-group input-group-flat">
                            <input type="text" name="penyebab" id="penyebab" value="{{ $trafo->penyebab }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No APKT</label>
                        <div class="input-group input-group-flat">
                            <input type="text" name="no_pk_apkt" id="no_pk_apkt" value="{{ $trafo->no_pk_apkt }}"
                                class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Beban (A)</label>
                        <div class="input-group input-group-flat">
                            <input inputmode="numeric" pattern="[0-9]*" type="text" name="bebanA" id="bebanA" value="{{ $trafo->bebanA }}"
                                class="form-control">
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
