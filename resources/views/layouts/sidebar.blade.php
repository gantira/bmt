<aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
    <div class="main-navbar">
        <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
            <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
                <div class="d-table m-auto">
                    <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="{{ asset('shards/images/shards-dashboards-logo.svg') }}"
                        alt="Shards Dashboard">
                    <span class="d-none d-md-inline ml-1">BMT</span>
                </div>
            </a>
            <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
            </a>
        </nav>
    </div>
    <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
        <div class="input-group input-group-seamless ml-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-search"></i>
                </div>
            </div>
            <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
        </div>
    </form>
    <div class="nav-wrapper">
        <ul class="nav flex-column">
            @can('home')
            <li class="nav-item">
                <a class="nav-link {{ $linkhome or '' }}" href="{{ route('home') }}">
                    <i class="material-icons">home</i>
                    <span>Home</span>
                </a>
            </li>
            @endcan
            @can('nasabah')
            <li class="nav-item">
                <a class="nav-link {{ $linknasabah or '' }} " href="{{ route('nasabah.index') }}">
                    <i class="material-icons">person</i>
                    <span>Nasabah</span>
                </a>
            </li>
            @endcan
            @can('simpanan')
            <li class="nav-item">
                <a class="nav-link {{ $linksimpanan or '' }}" href="{{ route('simpanan.index') }}">
                    <i class="material-icons">business_center</i>
                    <span>Simpanan</span>
                </a>
            </li>
            @endcan
            @can('pinjaman')
            <li class="nav-item">
                <a class="nav-link {{ $linkpinjaman or '' }}" href="{{ route('pinjaman.index') }}">
                    <i class="material-icons">business_center</i>
                    <span>Pinjaman</span>
                </a>
            </li>
            @endcan
            @can('penarikan')
            <li class="nav-item">
                <a class="nav-link {{ $linkpenarikan or '' }}" href="{{ route('penarikan.index') }}">
                    <i class="material-icons">attach_money</i>
                    <span>Penarikan</span>
                </a>
            </li>
            @endcan
            @can('laporan')
            <li class="nav-item">
                <a class="nav-link {{ $linklaporan or '' }}" href="{{ route('laporan.index') }}">
                    <i class="material-icons">book</i>
                    <span>Laporan</span>
                </a>
            </li>
            @endcan
            @can('roles')
            <li class="nav-item">
                <a class="nav-link {{ $linkrole or '' }}" href="{{ route('roles.index') }}">
                    <i class="material-icons">perm_data_setting</i>
                    <span>Role & Permission</span>
                </a>
            </li>
            @endcan
           
        </ul>
    </div>
</aside>
