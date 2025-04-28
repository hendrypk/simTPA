<nav id="sidebar" class="sidebar">
    <!-- Sidebar Toggle (Mobile) -->



    {{-- <aside id="sidebar" class="sidebar"> --}}
       <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Beranda -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Beranda</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.index') }}">
                    <i class="fas fa-fw fa-user-graduate"></i>
                    <span>Santri</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('donors.index') }}">
                    <i class="fas fa-fw fa-people-arrows fa-bounce"></i>
                    <span>Donatur</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('employees.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    {{-- <i class="fas fa-fw fa-people-arrows fa-bounce"></i> --}}
                    <span>Karyawan</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('trx.donor.index') }}">
                    <i class="fas fa-hand-holding-droplet"></i>
                    <span>Donasi</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('trx.index') }}">
                    <i class="fas fa-fw fa-wallet"></i>
                    <span>Transaksi</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('donors.index') }}">
                    <i class="fas fa-fw fa-chart-simple"></i>
                    <span>Rencana Keuangan</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('options.index') }}">
                    <i class="fas fa-fw fa-wrench"></i>
                    {{-- <i class="fa-solid fa-screwdriver-wrench"></i> --}}
                    <span>Pengaturan</span></a>
            </li>

            <!-- Divider -->
            {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->


</nav>


