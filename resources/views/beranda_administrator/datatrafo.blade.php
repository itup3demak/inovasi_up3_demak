@extends('layout/templateberanda')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-around">
            <div class="mt-3 mb-3 search_customer">
                <div class="row g-2">
                    <div class="col">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari trafo..."
                            onkeypress="handleKeyPress(event)" oninput="showSuggestions()" onclick="click_customer()">
                        <div id="suggestionList" class="dropdown">
                            <ul class="list-group"></ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button href="#" onclick="hapusPencarian()" class="btn btn-icon button_hapus_pencarian"
                            aria-label="Button">
                            <i class="fa-solid fa-x fa-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
            <select class="form-select pilih_peta" id="pilih_unit" name="pilih_unit">
                <option disabled selected>--- Pilih Unit ---</option>
                @foreach ($datarayon->unique() as $rayon)
                    <option value="{{ $rayon }}">
                        @if ($rayon == 'ULP DEMAK')
                            {{ $rayon = 'ULP DEMAK' }}
                        @endif
                        @if ($rayon == 'ULP TEGOWANU')
                            {{ $rayon = 'ULP TEGOWANU' }}
                        @endif
                        @if ($rayon == 'ULP PURWODADI')
                            {{ $rayon = 'ULP PURWODADI' }}
                        @endif
                        @if ($rayon == 'ULP WIROSARI')
                            {{ $rayon = 'ULP WIROSARI' }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="map" onclick="click_map()"></div>
    @foreach ($datatrafo as $trafo)
        <div class="modal modal-blur fade" id="{{ $trafo->id }}">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $trafo->nomor_tiang }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="detail_pelanggan">Nomor Tiang : <b>{{ $trafo->nomor_tiang }}</b> </p>
                        <p class="detail_pelanggan">Nomor Gardu : <b>{{ $trafo->nomor_gardu }}</b> </p>
                        <p class="detail_pelanggan">n : <b>{{ $trafo->n }}</b> </p>
                        <p class="detail_pelanggan">perhitungan_beban : <b>{{ $trafo->perhitungan_beban }}</b> </p>
                        <p class="detail_pelanggan">klasifikasi_beban : <b>{{ $trafo->klasifikasi_beban }}</b> </p>
                        <p class="detail_pelanggan">Google Maps : <a target="_blank"
                                href="https://www.google.com/maps?q={{ $trafo->latitude }},{{ $trafo->longitude }}"><b>https://www.google.com/maps?q={{ $trafo->latitude }}{{ $trafo->longitude }}</b></a>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        // Menanggapi event klik pada modal untuk menyembunyikan elemen pencarian
        $('.modal').on('show.bs.modal', function() {
            // Sembunyikan elemen pencarian
            $('.search_customer').hide();
        });

        // Menanggapi event klik pada modal untuk menampilkan kembali elemen pencarian
        $('.modal').on('hidden.bs.modal', function() {
            // Tampilkan kembali elemen pencarian
            $('.search_customer').show();
        });
    </script>
    <script>
        var map = L.map('map', {
            fullscreenControl: true,
            fullscreenControl: {
                pseudoFullscreen: false
            }
        }).setView([-6.90774243377773, 110.65198375582506], 10);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        L.control.locate({
            position: 'topleft',
            drawCircle: true,
            follow: true,
            setView: 'untilPan',
            keepCurrentZoomLevel: true,
            stopFollowingOnDrag: false,
            markerStyle: {
                weight: 1,
                opacity: 0.8,
                fillOpacity: 0.8
            },
            circleStyle: {
                weight: 1,
                clickable: false
            },
            icon: 'fa fa-location-arrow',
            metric: false,
            strings: {
                title: "Temukan Lokasi Anda",
                popup: "You are within {distance} {unit} from this point",
                outsideMapBoundsMsg: "You seem located outside the boundaries of the map"
            },
            locateOptions: {
                maxZoom: 16
            }
        }).addTo(map);

        var datatrafo = @json($datatrafo);

        datatrafo.forEach(trafo => {
            const icontrafo = L.icon({
                iconUrl: 'assets/img/tree.png',
                iconSize: [20, 20],
                iconAnchor: [20, 20],
            });
            const marker = L.marker([trafo.latitude, trafo.longitude], {
                icon: icontrafo
            }).addTo(map);

            marker.bindTooltip(trafo.perhitungan_beban).openTooltip();
            marker.on('click', () => $('#' + trafo.id).modal('show'));
        });

        

        var currentMarker;
    </script>
@endsection
