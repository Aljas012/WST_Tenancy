@extends('layouts.tenantPageLayout')
@section('content')
@section('title', 'Maintenance')

@php
$colorMapping = [
'purple' => 'primary',
'green' => 'success',
'orange' => 'warning',
'danger' => 'danger',
'azure' => 'info',
];
$cardColor = $colorMapping[$settings->color ?? 'purple'] ?? 'primary';
@endphp

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">

                <div class="card">
                    <div class="card-header card-header-{{ $cardColor }} d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Maintenance Table</h4>
                            <p class="card-category">List of all cars undergoing maintenance</p>
                        </div>
                        <button type="button" class="btn btn-{{ $cardColor }}" style="display: flex; align-items: center; gap: 8px;" id="openMaintenanceCarMechanic">
                            <i class="material-icons">handyman</i>
                            Add Maintenance
                        </button>
                    </div>
                    <div class="card-body table-responsive">
                        @include('components.maintenanceAdd')
                        @include('components.maintenanceUpdateDelete')

                        @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: "{{ session('success') }}",
                                showConfirmButton: true,
                                timer: 3000,
                                background: '#242830',
                                color: '#fff',

                            });
                        </script>
                        @endif

                        @if ($errors->any())
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: "{{ $errors->first() }}", // Show the first error message
                                showConfirmButton: true,
                                timer: 3000,
                                background: '#242830',
                                color: '#fff',
                            });
                        </script>
                        @endif

                        <div class="customTableWrapper">
                            <table class="table table-hover">
                                <colgroup>
                                    <col width="5%">
                                    <col width="25%">
                                    <col width="25%">
                                    <col width="15%">
                                    <col width="15%">
                                </colgroup>
                                <thead class="text-warning">
                                    <th>ID</th>
                                    <th>Plate Number</th>
                                    <th>Mechanic</th>
                                    <th>Started</th>
                                    <th>Ended</th>
                                </thead>
                                <tbody>
                                    @forelse($maintenances as $maintenance)
                                    <tr class="maintenance-row" style="cursor: pointer;"
                                        data-id="{{ $maintenance->id }}"
                                        data-plateNumber="{{ $maintenance->car->plate_number }}"
                                        data-mechanic="{{ $maintenance->mechanic->mechanicApplication->name }}"
                                        data-fixStart="{{ $maintenance->fix_start }}"
                                        data-concern="{{ $maintenance->car->concern }}"
                                        data-note="{{ $maintenance->note }}">
                                        <td>{{ $maintenance->id }}</td>
                                        <td>{{ $maintenance->car->plate_number }}</td>
                                        <td>{{ $maintenance->mechanic->mechanicApplication->name }}</td>
                                        <td>{{ $maintenance->fix_start }}</td>
                                        <td>{{ $maintenance->fix_end }}</td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400" style="text-align: center;">
                                            No Maintenance found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll('.maintenance-row');
        const maintenanceBtn = document.getElementById("openMaintenanceCarMechanic");
        const maintenanceCarMechanic = document.getElementById("maintenanceCarMechanic");
        const maintenanceUpdateDelete = document.getElementById("maintenanceUpdateDelete");
        const updateForm = document.querySelector('#updtMaintenanceForm');
        const table = document.querySelector('.table');

        maintenanceBtn?.addEventListener("click", function() {
            if (table) {
                table.classList.add('table-hidden');
                table.classList.remove('table-visible');
            }

            if (maintenanceCarMechanic) {
                maintenanceCarMechanic.style.display = "block";
                maintenanceCarMechanic.scrollIntoView({
                    behavior: "smooth"
                });

                maintenanceUpdateDelete.style.display = 'none';
                maintenanceUpdateDelete.scrollIntoView({
                    behavior: "smooth"
                });
            }
        });

        rows.forEach(row => {
            row.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const plateNumber = this.getAttribute('data-plateNumber');
                const mechanic = this.getAttribute('data-mechanic');
                const fixStart = this.getAttribute('data-fixStart');
                const concern = this.getAttribute('data-concern');
                const note = this.getAttribute('data-note');


                if (table) {
                    table.classList.add('table-hidden');
                    table.classList.remove('table-visible');
                }

                if (maintenanceUpdateDelete) {
                    maintenanceUpdateDelete.querySelector('#maintenanceUpdtDltId').value = id;
                    maintenanceUpdateDelete.querySelector('#pNumber').value = plateNumber;
                    maintenanceUpdateDelete.querySelector('#mechanic').value = mechanic;
                    maintenanceUpdateDelete.querySelector('#fixStart').value = fixStart;
                    maintenanceUpdateDelete.querySelector('#concern').value = concern;
                    maintenanceUpdateDelete.querySelector('#note').value = note;
                    updateForm.action = `/maintenance/${id}`;

                    maintenanceUpdateDelete.style.display = 'block';
                    maintenanceUpdateDelete.scrollIntoView({
                        behavior: "smooth"
                    });
                }
            });
        });


        const clsBtn = document.querySelector('#closeMaintenanceCarMechanicButton');
        if (clsBtn) {
            clsBtn.addEventListener('click', function() {

                maintenanceCarMechanic.style.display = 'none';

                if (table) {
                    table.classList.remove('table-hidden');
                    table.classList.add('table-visible');
                }
            });
        }

        const updtDltClsBtn = document.querySelector('#closeMaintenanceUpdateDeleteButton');
        if (updtDltClsBtn) {
            updtDltClsBtn.addEventListener('click', function() {

                maintenanceUpdateDelete.style.display = 'none';

                if (table) {
                    table.classList.remove('table-hidden');
                    table.classList.add('table-visible');
                }
            });
        }
    });
</script>


@endsection