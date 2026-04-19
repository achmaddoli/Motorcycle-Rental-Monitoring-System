<nav class="sidebar sidebar-offcanvas" id="sidebar">

    <!-- Tambahkan ini di <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <ul class="nav">
        <li class="nav-item">
            <div class="d-flex sidebar-profile">
                <div class="sidebar-profile-name">
                    <p class="sidebar-name">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="sidebar-designation">
                        Welcome
                    </p>
                </div>
            </div>
            <div class="nav-search">
                <div class="input-group">
                </div>
            </div>
            <p class="sidebar-menu-title">Dash menu</p>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fi fi-rr-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kendaraans.index') }}">
                <i class="fi fi-rs-motorcycle-front menu-icon"></i>
                <span class="menu-title">Kendaraan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('penggunas.index') }}">
                <i class="fi fi-rr-user menu-icon"></i>
                <span class="menu-title">Pengguna</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('sewas.index') }}">
                <i class="fi fi-rs-rent menu-icon"></i>
                <span class="menu-title">Sewa</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('monitorings.index') }}">
                <i class="fi fi-rr-dashboard-monitor menu-icon"></i>
                <span class="menu-title">Monitoring</span>
            </a>
        </li>
        </li>
        <li class="nav-item">

            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html">
                            Register </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">

            <div class="collapse" id="error">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404
                        </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500
                        </a></li>
                </ul>
            </div>
        </li>

    </ul>

</nav>
