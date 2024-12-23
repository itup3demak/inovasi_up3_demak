<nav class="navbar navbar-expand-lg bg-body-tertiary p-2" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/user">SIMASTER (Sistem Informasi Aset Terintegrasi)
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" style="margin-right: 40px;" id="navbarSupportedContent">
            <ul style="font-size: 13px;" class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item {{ $title == 'Peta Pelanggan' ? 'active' : '' }}">
                    <a class="nav-link" href="/user">Peta Pelanggan</a>
                </li>
                <li class="nav-item {{ $title == 'Entri Data' ? 'active' : '' }}">
                    <a class="nav-link" href="/entridata_user">Entri Data</a>
                </li>
            </ul>
            <div class="btn-group">
                <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item " href="/edit_user_simaster/{{auth()->user()->id}}">Edit</a></li>
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
