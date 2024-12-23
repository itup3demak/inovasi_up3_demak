@extends('layout/templateberanda')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-around">
            <div class="mt-3 mb-3 search_customer">
                <div class="row g-2">
                    <div class="col">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari pohon rabas..."
                            oninput="showSuggestions()" onclick="click_customer()">
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
            <select class="form-select pilih_peta" id="pilih_peta" name="pilih_peta">
                <option disabled selected>--- Pilih Area Unit ---</option>
                @foreach ($datarayon->unique() as $rayon)
                    <option value="{{ $rayon }}">
                        {{ $rayon }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="map" onclick="click_map()"></div>
    @foreach ($datapohon as $pohon)
        <div class="modal modal-blur fade" id="{{ $pohon->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $pohon->perlu_rabas }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="detail_pelanggan">No Tiang Section : <b>{{ $pohon->tiang_section }}</b></p>
                        <p class="detail_pelanggan">Google Maps : <a target="_blank"
                                href="https://www.google.com/maps?q={{ $pohon->latitude }},{{ $pohon->longitude }}"><b>Google
                                    Maps</b></a>
                        </p>
                        <p class="detail_pelanggan">Rayon : <b>{{ $pohon->rayon }}</b></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        var map = L.map('map', {
            fullscreenControl: true
        }).setView([-6.90774243377773, 110.65198375582506], 10);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var datapohon = @json($datapohon);

        // Tambahkan semua marker ke cluster
        datapohon.forEach(pohon => {
            const iconpohon = L.icon({
                iconUrl: 'assets/img/tree.png',
                iconSize: [20, 20],
                iconAnchor: [20, 20],
            });
            const marker = L.marker([pohon.latitude, pohon.longitude], {
                icon: iconpohon
            }).addTo(map);

            marker.on('click', () => $('#' + pohon.id).modal('show'));
        });

        $('#pilih_peta').change(function() {
            map.eachLayer(layer => {
                if (layer instanceof L.Marker) map.removeLayer(layer);
            });

            const selectedBeban = $(this).val();
            const filteredDataPeta = datapohon.filter(pohon => pohon.rayon === selectedBeban);

            filteredDataPeta.forEach(pohon => {
                const iconpohon = L.icon({
                    iconUrl: 'assets/img/tree.png',
                    iconSize: [20, 20],
                    iconAnchor: [20, 20],
                });
                const marker = L.marker([pohon.latitude, pohon.longitude], {
                    icon: iconpohon
                }).addTo(map);

                marker.on('click', () => $('#' + pohon.id).modal('show'));
            });
        });

        function showSuggestions() {
            var searchTerm = document.getElementById('searchInput').value.toLowerCase();
            var suggestionList = document.getElementById('suggestionList');
            var listGroup = suggestionList.querySelector('ul');
            listGroup.innerHTML = ''; // Kosongkan daftar setiap kali ada perubahan input

            var matchCount = 0; // Inisialisasi jumlah kecocokan
            datapohon.forEach(function(pohon) {
                if (pohon.perlu_rabas.toLowerCase().includes(searchTerm) && matchCount < 10) {
                    var listItem = document.createElement('li');
                    listItem.className = 'list-group-item';
                    listItem.textContent = pohon.perlu_rabas;
                    listItem.onclick = function() {
                        document.getElementById('searchInput').value = pohon.perlu_rabas;
                        listGroup.innerHTML = ''; // Kosongkan daftar setelah memilih
                        suggestionList.style.display = 'none';
                        showMarker(pohon); // Fokuskan ke marker di peta
                    };
                    listGroup.appendChild(listItem);
                    matchCount++;
                }
            });

            // Tampilkan atau sembunyikan dropdown berdasarkan hasil
            suggestionList.style.display = listGroup.childElementCount > 0 ? 'block' : 'none';
        }

        function showMarker(pohon) {
            markerClusterGroup.clearLayers(); // Kosongkan cluster sebelumnya

            var marker = L.marker([
                parseFloat(pohon.latitude.replace(',', '.')),
                parseFloat(pohon.longitude.replace(',', '.'))
            ], {
                icon: L.icon({
                    iconUrl: 'assets/img/tree.png',
                    iconSize: [20, 20],
                    iconAnchor: [10, 20],
                })
            });

            marker.bindTooltip(pohon.perlu_rabas).openTooltip();
            marker.on('click', function() {
                $('#' + pohon.id).modal('show');
            });

            markerClusterGroup.addLayer(marker);
            map.setView([
                parseFloat(pohon.latitude.replace(',', '.')),
                parseFloat(pohon.longitude.replace(',', '.'))
            ], 19);
        }

        function hapusPencarian() {
            document.getElementById('searchInput').value = ""; // Kosongkan input
            document.getElementById('suggestionList').style.display = 'none'; // Sembunyikan saran
        }

        function click_customer() {
            document.getElementById('suggestionList').style.display = 'block'; // Tampilkan dropdown
        }

        document.addEventListener('click', function(event) {
            var suggestionList = document.getElementById('suggestionList');
            if (event.target !== suggestionList && !suggestionList.contains(event.target)) {
                suggestionList.style.display = 'none'; // Sembunyikan jika klik di luar
            }
        });
    </script>
@endsection
