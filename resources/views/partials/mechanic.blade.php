<li class="nav-item {{ request()->routeIs('mechanic.*') ? 'active' : '' }}" data-id="mechanic">
    <a class="nav-link" href="{{ route('mechanic.index') }}">
        <i class="material-icons">people_alt</i>
        <p>Mechanic</p>
    </a>
</li>