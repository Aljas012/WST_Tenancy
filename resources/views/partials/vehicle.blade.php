<li class="nav-item {{ request()->routeIs('car.*') ? 'active' : '' }}" data-id="vehicle">
    <a class="nav-link" href="{{ route('car.index') }}">
        <i class="material-icons">commute</i>
        <p>Vehicle</p>
    </a>
</li>