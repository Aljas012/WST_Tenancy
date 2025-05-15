<li class="nav-item {{ request()->routeIs('tenant_admin_dashboard') ? 'active' : '' }}"
    data-id="dashboard">
    <a class="nav-link" href="{{ route('tenant_admin_dashboard') }}">
        <i class="material-icons">dashboard</i>
        <p>Dashboard</p>
    </a>
</li>