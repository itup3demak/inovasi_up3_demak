<nav class="navbar navbar-expand-lg navbar-transparent bg-body-tertiary p-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="/koordinator">SIMASTER (Sistem Informasi Aset Terintegrasi)
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" style="margin-right: 40px;" id="navbarSupportedContent">
            <ul style="font-size: 13px;" class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item {{ $title == 'Manajemen Aset Jaringan' ? 'active' : '' }}">
                    <a class="nav-link" href="/manajemen_aset_jaringan">Manajemen Aset Jaringan</a>
                </li>
                {{-- <li class="nav-item {{ $title == 'Manajemen Penyambungan' ? 'active' : '' }}">
                    <a class="nav-link" href="/paka">Manajemen Penyambungan</a>
                </li>
                <li class="nav-item {{ $title == 'Manajemen Pelanggan' ? 'active' : '' }}">
                    <a class="nav-link" href="/entripadam">Manajemen Pelanggan</a>
                </li>
                <li class="nav-item {{ $title == 'Kinerja UP3' ? 'active' : '' }}">
                    <a class="nav-link" href="/entripadam">Kinerja UP3</a>
                </li> --}}
                <li class="nav-item {{ $title == 'Updating Koordinator' ? 'active' : '' }}">
                    <a class="nav-link" href="/updating_koordinator">Updating Koordinator</a>
                </li>
            </ul>
            <div class="btn-group">
                <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item " href="/edit_user_simaster/{{ auth()->user()->id }}">Edit</a></li>
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
