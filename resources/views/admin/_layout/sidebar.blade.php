<nav id="sidebar" class="sidebar">

    <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

        <hr class="sidebar-divider my-0">
    
        <x-sidebar-item route="dashboard" icon="fa-tachometer-alt" label="Beranda" :permission="'view dashboard'" />
        <x-sidebar-item route="student.index" icon="fa-user-graduate" label="Santri" :permission="'view student'" />
        <x-sidebar-item route="donors.index" icon="fa-people-arrows" label="Donatur" :permission="'view donor'" />
        <x-sidebar-item route="employees.index" icon="fa-users" label="Karyawan" :permission="'view employee'" />
        <x-sidebar-item route="vendor.index" icon="fa-users" label="Vendor" :permission="'view vendor'" />
        <x-sidebar-item route="trx.donor.index" icon="fa-hand-holding-droplet" label="Donasi" :permission="'view donate'" />
        <x-sidebar-item route="trx.index" icon="fa-wallet" label="Transaksi" :permission="'view transaction'" />
        <x-sidebar-item route="options.index" icon="fa-wrench" label="Pengaturan" :permission="'view setting'" />
        <x-sidebar-item route="roles.index" icon="fa-user-tag" label="Role & User" :permission="'view role'" />
        <x-sidebar-item route="account.edit" icon="fa-people-arrows" label="Akun" :permission="'view dashboard'" />
        
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
        

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>


    
    </ul>

</nav>


