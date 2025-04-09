<nav id="sidebar" class="sidebar">
    <!-- Sidebar Toggle (Mobile) -->



    {{-- <aside id="sidebar" class="sidebar"> --}}
       <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Beranda -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Beranda</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Santri</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-people-arrows fa-bounce"></i>
                    <span>Data Donatur</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#employment"
                    aria-expanded="true" aria-controls="employment">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span>Kepegawaian</span>
                </a>
                <div id="employment" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="cards.html">Pengajar</a>
                        <a class="collapse-item" href="cards.html">Pengurus</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#finance"
                    aria-expanded="true" aria-controls="finance">
                    <i class="fas fa-fw fa-wallet"></i>
                    <span>Keuangan</span>
                </a>
                <div id="finance" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="buttons.html">Donasi</a>
                        <a class="collapse-item" href="cards.html">Transaksi</a>
                        <a class="collapse-item" href="cards.html">Rencana Keuangan</a>
                    </div>
                </div>
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


