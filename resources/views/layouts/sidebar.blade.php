<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-handshake"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'SIM MoU') }}</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('app/dashboard*') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('app/document*') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('documents')}}">
            <i class="fa-solid fa-file-contract"></i>
            <span>Documents</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('app/partner/*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('app/partner/*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePartner" aria-expanded="true" aria-controls="collapsePartner">
            <i class="fa-solid fa-building-columns"></i>
            <span>Partners</span>
        </a>
        <div id="collapsePartner" class="collapse {{ request()->is('app/partner/*') ? 'show' : '' }}" aria-labelledby="headingPartner" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Partner data:</h6>
                <a class="collapse-item {{ request()->is('app/partner/institutions') ? 'active' : '' }}" href="{{route('institutions')}}">Institutions</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ request()->is('app/contacts') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('contacts')}}">
            <i class="fa-solid fa-address-book"></i>
            <span>Contacts</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('app/programs') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('programs')}}">
            <i class="fa-solid fa-object-group"></i>
            <span>Programs</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        References
    </div>
    <li class="nav-item {{ request()->is('app/internal/*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('app/internal/*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInternal" aria-expanded="true" aria-controls="collapseInternal">
            <i class="fa-solid fa-school"></i> <span>Internal</span>
        </a>
        <div id="collapseInternal" class="collapse {{ request()->is('app/internal/*') ? 'show' : '' }}" aria-labelledby="headingInternal" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Internal:</h6>
                <a class="collapse-item {{ request()->is('app/internal/institution') ? 'active' : '' }}" href="{{ route('internal.institution') }}">Institution</a>
                <a class="collapse-item {{ request()->is('app/internal/units') ? 'active' : '' }}" href="{{ route('internal.units') }}">Units</a>
            </div>
        </div>
    </li>
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
                <h6 class="collapse-header">Institution:</h6>
                <a class="collapse-item {{ request()->is('app/miscellaneous/institution/types') ? 'active' : '' }}" href="{{ route('institutionTypes') }}">Institution Types</a>
                <h6 class="collapse-header">Document:</h6>
                <a class="collapse-item {{ request()->is('app/miscellaneous/document/types') ? 'active' : '' }}" href="{{ route('documentTypes') }}">Document Types</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Control Center
    </div>
    <li class="nav-item {{ request()->is('app/control/user') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('users')}}">
            <i class="fa-solid fa-users"></i> <span>Users</span>
        </a>
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
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>