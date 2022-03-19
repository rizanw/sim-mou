<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-handshake"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'SIM MoU') }}</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('home/documents') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('home')}}">
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
                <a class="collapse-item" href="{{route('institutions')}}">Institutions</a>
                <a class="collapse-item" href="{{route('home')}}">Units</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ request()->is('home/contacts') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('home')}}">
            <i class="fa-solid fa-address-book"></i>
            <span>Contacts</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        References
    </div>
    <li class="nav-item {{ request()->is('app/area/*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('app/area/*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseArea" aria-expanded="true" aria-controls="collapseArea">
            <i class="fa-solid fa-map-location-dot"></i> <span>Area</span>
        </a>
        <div id="collapseArea" class="collapse {{ request()->is('app/area/*') ? 'show' : '' }}" aria-labelledby="headingArea" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Area:</h6>
                <a class="collapse-item {{ request()->is('app/area/continents') ? 'active' : '' }}" href="{{ route('continents') }}">Continents</a>
                <a class="collapse-item {{ request()->is('app/area/countries') ? 'active' : '' }}" href="{{ route('countries') }}">Countries</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ request()->is('app/miscellaneous/*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('app/miscellaneous/*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMiscellaneous" aria-expanded="true" aria-controls="collapseMiscellaneous">
            <i class="fa-solid fa-database"></i> <span>Miscellaneous</span>
        </a>
        <div id="collapseMiscellaneous" class="collapse {{ request()->is('app/miscellaneous/*') ? 'show' : '' }}" aria-labelledby="headingMiscellaneous" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Institute:</h6>
                <a class="collapse-item {{ request()->is('app/miscellaneous/institute/types') ? 'active' : '' }}" href="{{ route('instituteTypes') }}">Types</a>
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
                <a class="collapse-item" href="{{route('home')}}">Edit Profile</a>
                <a class="collapse-item" href="{{route('home')}}">Change Password</a>
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
                <!-- <a class="collapse-item" href="{{route('home')}}">Logged Activities</a>
                <a class="collapse-item" href="{{route('home')}}">Logged Log-in</a> -->
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