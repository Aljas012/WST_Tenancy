<link href="../dist/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Central Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-white dark:bg-gray-800">

                <div class="card-header card-header-info">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="card-title" style="font-weight: 600; font-size: 20px">Tenant Table</h4>
                            <p class="card-category">Listing of All Tenants and Their Details</p>
                        </div>
                    </div>
                </div>

                <div class="card-body" x-data="{ showTenantInformation: false, selectedTenant: {} }">
                    @include('centralApp.tenantInformation')

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

                    <div class="customTableWrapper" x-show="!showTenantInformation">
                        <table class="table table-hover table-responsive">
                            <colgroup>
                                <col width="5%">
                                <col width="20%">
                                <col width="20%">
                                <col width="15%">
                                <col width="15%">
                                <col width="15%">
                            </colgroup>
                            <thead class="text-warning dark:text-gray-300">
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Domain</th>
                                    <th>Subscription</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="dark:text-gray-400">
                                @forelse ($tenant_application as $tenant)
                                <tr class="customClickRow hover:bg-gray-200 dark:hover:bg-gray-700" @click="showTenantInformation = true; selectedTenant = {{ json_encode($tenant->load('tenantInfo')) }}">
                                    <td>{{ $tenant->id }}</td>
                                    <td>{{ $tenant->full_name }}</td>
                                    <td>{{ $tenant->email }}</td>
                                    <td>{{ $tenant->domain }}</td>
                                    <td>{{ $tenant->subscription }}</td>
                                    <td
                                        class="{{ 
                                            ($tenant->tenantInfo)->domain_status == 'Active' ? 'status-approved' : 
                                            (($tenant->tenantInfo)->domain_status == 'Paused' ? 'status-paused' : '') 
                                        }}">
                                        {{ ($tenant->tenantInfo)->domain_status }}
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400" style="text-align: center;">
                                        No Tenants found.
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
</x-app-layout>