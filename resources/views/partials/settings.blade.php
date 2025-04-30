<li class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}"
    data-id="settings">
    <a class="nav-link" href="{{ route('settings.index') }}">
        <i class="material-icons">settings</i>
        <p>Settings</p>
    </a>
</li>