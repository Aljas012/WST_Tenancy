@extends('layouts.tenantPageLayout')
@section('content')
@section('title', 'Mechanic')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">

                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Mechanic Table</h4>
                        <p class="card-category">List of all mechanics who have signed up</p>
                    </div>
                    <div class="card-body table-responsive">
                        @include('components.mechanicUpdateDelete')
                        @include('components.mechanicApproveReject')

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

                        <table class="table table-hover">
                            <colgroup>
                                <col width="5%">
                                <col width="20%">
                                <col width="20%">
                                <col width="15%">
                                <col width="20%">
                                <col width="10%">
                            </colgroup>
                            <thead class="text-warning">
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse ($mechanics as $mechanic)
                                <tr class="mechanic-row" style="cursor: pointer;"
                                    data-id="{{ $mechanic->id }}"
                                    data-name="{{ $mechanic->name }}"
                                    data-email="{{ $mechanic->email }}"
                                    data-contact="{{ $mechanic->contact }}"
                                    data-address="{{ $mechanic->address }}"
                                    data-status="{{ $mechanic->status }}">

                                    <td>{{ $mechanic->id }}</td>
                                    <td>{{ $mechanic->name }}</td>
                                    <td>{{ $mechanic->email }}</td>
                                    <td>{{ $mechanic->contact }}</td>
                                    <td>{{ $mechanic->address }}</td>
                                    <td class="{{ $mechanic->status === 'Pending' ? 'text-danger' : 'text-success' }}">
                                        {{ $mechanic->status }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400" style="text-align: center;">
                                        No Mechanic found.
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.mechanic-row');
        const updateDeleteModal = document.getElementById('mechanicUpdateDelete');
        const approveRejectModal = document.getElementById('mechanicApproveReject');
        const updateForm = document.querySelector('#mechanicUpdateForm');
        const table = document.querySelector('.table');

        rows.forEach(row => {
            row.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const contact = this.getAttribute('data-contact');
                const address = this.getAttribute('data-address');
                const status = this.getAttribute('data-status');

                // Hide table
                if (table) {
                    table.classList.add('table-hidden');
                    table.classList.remove('table-visible');
                }

                // Show correct modal based on status
                if (status === 'Pending') {
                    if (approveRejectModal) {
                        approveRejectModal.querySelector('#mechanic_aapplication_id').value = id;
                        approveRejectModal.querySelector('#fname').value = name;
                        approveRejectModal.querySelector('#eaddress').value = email;
                        approveRejectModal.querySelector('#pnumber').value = contact;
                        approveRejectModal.querySelector('#address').value = address;

                        approveRejectModal.style.display = 'block';
                        approveRejectModal.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                } else if (status === 'Active') {
                    if (updateDeleteModal) {
                        updateDeleteModal.querySelector('#mechanic_application_id').value = id;
                        updateDeleteModal.querySelector('#fname').value = name;
                        updateDeleteModal.querySelector('#eaddress').value = email;
                        updateDeleteModal.querySelector('#pnumber').value = contact;
                        updateDeleteModal.querySelector('#address').value = address;
                        updateForm.action = `/mechanic/${id}`;

                        updateDeleteModal.style.display = 'block';
                        updateDeleteModal.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // Close button for mechanicUpdateDelete
        const closeMechanicUpdateDeleteButton = document.querySelector('#closeMechanicUpdateDeleteButton');
        if (closeMechanicUpdateDeleteButton) {
            closeMechanicUpdateDeleteButton.addEventListener('click', function() {
                updateDeleteModal.style.display = 'none';
                if (table) {
                    table.classList.remove('table-hidden');
                    table.classList.add('table-visible');
                }
            });
        }

        // Optional: Close button for mechanicApproveReject
        const closeMechanicApproveRejectButton = document.querySelector('#closeMechanicApproveRejectButton');
        if (closeMechanicApproveRejectButton) {
            closeMechanicApproveRejectButton.addEventListener('click', function() {
                approveRejectModal.style.display = 'none';
                if (table) {
                    table.classList.remove('table-hidden');
                    table.classList.add('table-visible');
                }
            });
        }
    });
</script>



@endsection