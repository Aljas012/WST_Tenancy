<li class="nav-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}" data-id="inventory">
    <a class="nav-link" href="{{ route('inventory.index') }}">
        <i class="material-icons">inventory_2</i>
        <p>Inventory</p>
    </a>
</li>