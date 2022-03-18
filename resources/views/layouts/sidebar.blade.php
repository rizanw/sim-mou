<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-handshake"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'SIM MoU') }}</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('dashboard/documents') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fa-solid fa-file-contract"></i>
            <span>Documents</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePartner" aria-expanded="true" aria-controls="collapsePartner">
            <i class="fa-solid fa-handshake-simple"></i>
            <span>Partners</span>
        </a>
        <div id="collapsePartner" class="collapse" aria-labelledby="headingPartner" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Partner data:</h6>
                <a class="collapse-item" href="{{route('dashboard')}}">Institutions</a>
                <a class="collapse-item" href="{{route('dashboard')}}">Units</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ request()->is('dashboard/contacts') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fa-solid fa-address-book"></i>
            <span>Contacts</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Table Editor
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCountry" aria-expanded="true" aria-controls="collapseCountry">
            <i class="fas fa-flag"></i> <span>Country</span>
        </a>
        <div id="collapseCountry" class="collapse" aria-labelledby="headingCountry" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Country:</h6>
                <a class="collapse-item" href="{{ route('dashboard') }}">List Country</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Settings
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-users-cog"></i> <span>User</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User : {{Auth::user()->name}}:</h6>
                <a class="collapse-item" href="{{route('dashboard')}}">Edit Profile</a>
                <a class="collapse-item" href="{{route('dashboard')}}">Change Password</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUserGuide" aria-expanded="true" aria-controls="collapseUserGuide">
            <i class="fas fa-book"></i> <span>User Guide</span>
        </a>
        <div id="collapseUserGuide" class="collapse" aria-labelledby="headingUAM" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Guide:</h6>
                <a class="collapse-item" href="{{asset('storage/siip_userguide.pdf')}}" target="_blank">Download User Guide</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUAM" aria-expanded="true" aria-controls="collapseUAM">
            <i class="fas fa-list"></i> <span>User Activity Monitor</span>
        </a>
        <div id="collapseUAM" class="collapse" aria-labelledby="headingUAM" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Logs:</h6>
                <!-- <a class="collapse-item" href="{{route('dashboard')}}">Logged Activities</a>
                <a class="collapse-item" href="{{route('dashboard')}}">Logged Log-in</a> -->
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>