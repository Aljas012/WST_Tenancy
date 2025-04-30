@extends('layouts.tenantPageLayout')
@section('content')
@section('title', 'Vehicle')

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
                            <h4 class="card-title">Vehicle Table</h4>
                            <p class="card-category">List of all cars for maintenance</p>
                        </div>
                        <button type="button" class="btn btn-{{ $cardColor }}" style="display: flex; align-items: center; gap: 8px;" id="openAddCar">
                            <i class="material-icons">commute</i>
                            Add Vehicle
                        </button>
                    </div>
                    <div class="card-body table-responsive">
                        @include('components.carAdd')
                        @include('components.carUpdateDelete')

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

                        @if (session('error'))
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: "{{ session('error') }}",
                                showConfirmButton: true,
                                timer: 5000,
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

                        <div class="customTableWrapper scrollbar-{{ $cardColor }}">
                            <table class="table table-hover">
                                <colgroup>
                                    <col width="5%">
                                    <col width="20%">
                                    <col width="20%">
                                    <col width="20%">
                                    <col width="20%">
                                    <col width="15%">
                                </colgroup>
                                <thead class="text-warning">
                                    <th>ID</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Plate Number</th>
                                    <th>Concern</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    @forelse($cars as $car)
                                    <tr class="car-row" style="cursor: pointer;"
                                        data-id="{{ $car->id }}"
                                        data-brand="{{ $car->brand }}"
                                        data-model="{{ $car->model }}"
                                        data-plate_number="{{ $car->plate_number }}"
                                        data-concern="{{ $car->concern }}">

                                        <td>{{ $car->id }}</td>
                                        <td>{{ $car->brand }}</td>
                                        <td>{{ $car->model }}</td>
                                        <td>{{ $car->plate_number }}</td>
                                        <td>{{ $car->concern }}</td>
                                        <td class=" {{ $car->status === 'Waiting' ? 'text-danger' : 'text-success' }}">
                                            {{ $car->status }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400" style="text-align: center;">
                                            No Cars Found.
                                        </td>
                                    </tr>
                                    @endforelse
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
        const rows = document.querySelectorAll('.car-row');
        const addCarBtn = document.getElementById("openAddCar");
        const addCarSection = document.getElementById("addCar");
        const carUpdateDelete = document.getElementById("carUpdateDelete");
        const updateForm = document.querySelector('#carUpdateForm');
        const table = document.querySelector('.table');

        addCarBtn?.addEventListener("click", function() {
            if (table) {
                table.classList.add('table-hidden');
                table.classList.remove('table-visible');
            }

            if (addCarSection) {
                addCarSection.style.display = "block";
                addCarSection.scrollIntoView({
                    behavior: "smooth"
                });

                carUpdateDelete.style.display = 'none';
                carUpdateDelete.scrollIntoView({
                    behavior: "smooth"
                });
            }
        });

        rows.forEach(row => {
            row.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const brand = this.getAttribute('data-brand');
                const model = this.getAttribute('data-model');
                const plateNumber = this.getAttribute('data-plate_number');
                const concern = this.getAttribute('data-concern');

                if (table) {
                    table.classList.add('table-hidden');
                    table.classList.remove('table-visible');
                }

                if (carUpdateDelete) {
                    carUpdateDelete.querySelector('#updateCarId').value = id;
                    carUpdateDelete.querySelector('#updateBrand').value = brand;
                    carUpdateDelete.querySelector('#updateModel').value = model;
                    carUpdateDelete.querySelector('#updatePlateNumber').value = plateNumber;
                    carUpdateDelete.querySelector('#updateConcern').value = concern;
                    updateForm.action = `/car/${id}`;

                    carUpdateDelete.style.display = 'block';
                    carUpdateDelete.scrollIntoView({
                        behavior: "smooth"
                    });
                }
            });
        });

        const clsBtn = document.querySelector('#closeAddCarButton');
        if (clsBtn) {
            clsBtn.addEventListener('click', function() {
                addCarSection.style.display = 'none';
                if (table) {
                    table.classList.remove('table-hidden');
                    table.classList.add('table-visible');
                }
            });
        }

        const clsBtnUpdDlt = document.querySelector('#closeUpdateDeleteButton');
        if (clsBtnUpdDlt) {
            clsBtnUpdDlt.addEventListener('click', function() {
                carUpdateDelete.style.display = 'none';
                if (table) {
                    table.classList.remove('table-hidden');
                    table.classList.add('table-visible');
                }
            });
        }
    });
</script>





@endsection