<li class="nav-item {{ request()->routeIs('maintenance.*') ? 'active' : '' }}"
    data-id="maintenance">
    <a class="nav-link" href="{{ route('maintenance.index') }}">
        <i class="material-icons">handyman</i>
        <p>Maintenance</p>
    </a>
</li>