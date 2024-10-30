<nav class="navbar navbar-expand-lg bg-body-tertiary p-2 fixed-top" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/koordinator"> SIMPELTAS (Sistem Monitoring Pelanggan Prioritas)
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" style="margin-right: 40px;" id="navbarSupportedContent">
            <ul style="font-size: 13px;" class="navbar-nav me-auto mb-2 mb-lg-0">
                <li
                    class="nav-item {{ in_array($title, ['Koordinator', 'Pelanggan Demak', 'Pelanggan Tegowanu', 'Pelanggan Purwodadi', 'Pelanggan Wirosari']) ? 'active' : '' }} dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Pelanggan APP
                    </a>
                    <ul class="dropdown-menu" style="font-size: 13px;">
                        <li><a class="dropdown-item" href="/koordinator">Semua Pelanggan APP</a></li>
                        <li><a class="dropdown-item" href="/pelanggan_demak">Pelanggan Demak</a></li>
                        <li><a class="dropdown-item" href="/pelanggan_tegowanu">Pelanggan Tegowanu</a></li>
                        <li><a class="dropdown-item" href="/pelanggan_purwodadi">Pelanggan Purwodadi</a></li>
                        <li><a class="dropdown-item" href="/pelanggan_wirosari">Pelanggan Wirosari</a></li>
                    </ul>
                </li>
            </ul>
            <div class="btn-group">
                <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item " href="/edit_user_simpeltas/{{ auth()->user()->id }}">Edit</a></li>
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
