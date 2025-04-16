<link rel="stylesheet" href="dist/css/customStyle.css">
<div x-show="showTenantInformation" x-cloak class="dark:bg-gray-800 w-full mt-2 p-6 border rounded-lg">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BACK BUTTON -->
    <div style="margin-left: 1rem">
        <button class="flex items-center gap-3" @click="showTenantInformation = false">
            <i class="fa-solid fa-arrow-right-from-bracket fa-flip-horizontal"></i>
            <p class="text-md">Back</p>
        </button>
    </div>

    <form :action="'/tenant_application/' + selectedTenant.id" method="POST">
        @csrf
        @method('PUT')

        <div class="px-4" style="margin-top: 1rem">
            <div>

                <div class="flex justify-between items-center  mb-3">
                    <div class="flex items-center gap-4">
                        <p>Full Name:</p>
                        <h3 class="text-lg font-semibold" x-text="selectedTenant.full_name"></h3>
                    </div>
                    <div class="flex items-center gap-4">
                        <p>Email Address:</p>
                        <h3 class="text-lg font-semibold" x-text="selectedTenant.email"></h3>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center gap-4">
                        <p>Website Domain:</p>
                        <h3 class="text-lg font-semibold" x-text="selectedTenant.domain"></h3>
                    </div>

                    <div class="flex items-center gap-4">
                        <p>Phone Number:</p>
                        <h3 class="text-lg font-semibold" x-text="selectedTenant.contact"></h3>
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-4">
                        <p>Business Type:</p>
                        <h3 class="text-lg font-semibold" x-text="selectedTenant.business"></h3>
                    </div>
                </div>
            </div>

            <div class="w-full" style="margin-top: 1rem">
                <h3 class="text-lg font-semibold mb-2">
                    Subscription
                </h3>

                <table class="table  table-responsive border">
                    <colgroup>
                        <col width="20%">
                        <col width="25%">
                        <col width="25%">
                        <col width="30%">
                    </colgroup>
                    <thead class="dark:text-gray-300 ">
                        <tr>
                            <td>Type</td>
                            <td>Started</td>
                            <td>Deadline</td>
                            <td>Actions</td>
                        </tr>
                    </thead>

                    <tbody class="dark:text-gray-400">
                        <tr>
                            <td>
                                <span x-show="selectedTenant.tenant_info?.application_status !== 'Approved'" x-text="selectedTenant.subscription"></span>

                                <select x-show="selectedTenant.tenant_info?.application_status === 'Approved'" x-model="selectedTenant.subscription" class="w-full p-1 rounded dark:bg-gray-800">
                                    <option value="Free">Free</option>
                                    <option value="Month">Month</option>
                                    <option value="Year">Year</option>
                                </select>
                            </td>

                            <td x-text="selectedTenant.tenant_info?.subscription_start_date "></td>
                            <td x-text="selectedTenant.tenant_info?.subscription_end_date ?? 'Deadline Free'"></td>

                            <td>
                                <div style="display: flex; justify-content: start">
                                    <!-- Approve Button for Pending Status -->
                                    <button
                                        x-show="selectedTenant.tenant_info?.application_status === 'Pending'"
                                        type="submit"
                                        class="approve-button"
                                        style="margin-right: 8px;"
                                        x-data="{ loading: false }"
                                        x-init="$el.closest('form').addEventListener('submit', () => loading = true)"
                                        x-bind:disabled="loading">

                                        <template x-if="!loading">
                                            <span>
                                                <i class="fas fa-check-circle mr-2"></i> Approve
                                            </span>
                                        </template>
                                        <template x-if="loading">
                                            <span>
                                                <i class="fas fa-spinner fa-spin mr-2"></i> Approving...
                                            </span>
                                        </template>
                                    </button>

                                    <!-- Reject Button -->
                                    <button
                                        x-show="selectedTenant.tenant_info?.application_status === 'Pending'"
                                        type="button"
                                        class="reject-button"
                                        :disabled="loading"
                                        @click="
                                        confirmAction('Reject this tenant application?', () => {
                                            loading = true;
                                            rejectTenant(selectedTenant.id)
                                                .then(() => {
                                                    loading = false;
                                                })
                                                .catch(() => {
                                                    loading = false;
                                                });
                                        })
                                    "
                                        x-data="{ loading: false }">

                                        <template x-if="!loading">
                                            <span>
                                                <i class="fas fa-times-circle mr-2"></i> Reject
                                            </span>
                                        </template>
                                        <template x-if="loading">
                                            <span>
                                                <i class="fas fa-spinner fa-spin mr-2"></i> Rejecting...
                                            </span>
                                        </template>
                                    </button>
                                </div>

                                <template x-if="selectedTenant.tenant_info?.application_status === 'Approved'">
                                    <div class="flex gap-3">
                                        <!-- Pause/Resume Button -->
                                        <button
                                            type="button"
                                            class="action-button pause"
                                            :disabled="loading"
                                            @click="
                                                confirmAction(
                                                    selectedTenant.tenant_info?.domain_status === 'Paused' ? 'Resume tenant?' : 'Pause tenant?',
                                                    () => {
                                                        loading = true;
                                                        const action = selectedTenant.tenant_info?.domain_status === 'Paused' ? resumeTenant : pauseTenant;

                                                        action(selectedTenant.id).then(() => {
                                                                selectedTenant.tenant_info?.domain_status === 'Paused' ? 'Active' : 'Paused';
                                                            loading = false;
                                                        }).catch(() => {
                                                            loading = false;
                                                        });
                                                    }
                                                )
                                            "
                                            x-data="{ loading: false }">

                                            <template x-if="!loading">
                                                <span class="flex items-center gap-2">
                                                    <i class="fas"
                                                        :class="selectedTenant.tenant_info?.domain_status === 'Paused' ? 'fa-play' : 'fa-pause'"></i>
                                                    <span x-text="selectedTenant.tenant_info?.domain_status === 'Paused' ? 'Resume' : 'Pause'"></span>
                                                </span>
                                            </template>

                                            <template x-if="loading">
                                                <span class="flex items-center gap-2">
                                                    <i class="fas fa-spinner fa-spin mr-1"></i>
                                                    <span
                                                        x-text="selectedTenant.tenant_info?.domain_status === 'Paused' ? 'Resuming...' : 'Pausing...'"></span>
                                                </span>
                                            </template>
                                        </button>

                                        <!-- Update Button -->
                                        <button type="button"
                                            class="action-button update"
                                            :disabled="loading"
                                            @click="
                                                confirmAction('Update subscription?', () => {
                                                    loading = true;
                                                    updateSubscription(selectedTenant.id, selectedTenant.subscription)
                                                        .then(() => {
                                                            loading = false;
                                                        })
                                                        .catch(() => {
                                                            loading = false;
                                                        });
                                                })
                                            "
                                            x-data="{ loading: false }">

                                            <!-- Normal button content (when not loading) -->
                                            <template x-if="!loading">
                                                <span class="flex items-center gap-2">
                                                    <i class="fas fa-edit"></i>
                                                    <span>Update</span>
                                                </span>
                                            </template>

                                            <!-- Loading state content -->
                                            <template x-if="loading">
                                                <span class="flex items-center gap-2">
                                                    <i class="fas fa-spinner fa-spin mr-1"></i>
                                                    <span>Updating...</span>
                                                </span>
                                            </template>
                                        </button>


                                        <!-- Delete Button -->
                                        <button type="button"
                                            class="action-button delete"
                                            :disabled="loading"
                                            @click="
                                                confirmAction('Delete tenant!', () => {
                                                    loading = true;
                                                    deleteTenant(selectedTenant.id)
                                                        .then(() => {
                                                            loading = false;
                                                        })
                                                        .catch(() => {
                                                            loading = false;
                                                        });
                                                })
                                            "
                                            x-data="{ loading: false }">

                                            <template x-if="!loading">
                                                <span class="flex items-center gap-2">
                                                    <i class="fas fa-trash"></i>
                                                    <span>Delete</span>
                                                </span>
                                            </template>


                                            <template x-if="loading">
                                                <span class="flex items-center gap-2">
                                                    <i class="fas fa-spinner fa-spin mr-1"></i>
                                                    <span>Deleting...</span>
                                                </span>
                                            </template>
                                        </button>
                                    </div>
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <script>
        function pauseTenant(tenant) {
            fetch(`/tenant/${tenant}/pause`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Paused Successfully!',
                        text: data.pSuccess,
                        background: '#242830',
                        color: '#fff',
                        confirmButtonColor: '#3085d6',
                    }).finally(() => {
                        location.reload();
                    });
                })
                .catch(err => console.error(err));
        }

        function resumeTenant(tenant) {
            fetch(`/tenant/${tenant}/resume`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Resume Successfully!',
                        text: data.rSuccess,
                        background: '#242830',
                        color: '#fff',
                        confirmButtonColor: '#3085d6',
                    }).finally(() => {
                        location.reload();
                    });
                })
                .catch(err => console.error(err));
        }

        function updateSubscription(tenant, newSubscription) {
            console.log(tenant, newSubscription)
            fetch(`/tenant/${tenant}/update_subscription`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        subscription: newSubscription
                    })
                })
                .then(res => res.json())

                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Subscription updated!',
                        text: data.sSuccess,
                        background: '#242830',
                        color: '#fff',
                        confirmButtonColor: '#3085d6',
                    }).finally(() => {
                        location.reload();
                    });
                })
                .catch(err => console.error(err));
        }

        function deleteTenant(tenant) {
            fetch(`/tenant/${tenant}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.dSuccess,
                        background: '#242830',
                        color: '#fff',
                        confirmButtonColor: '#3085d6',
                    }).finally(() => {
                        location.reload();
                    });
                })
                .catch(err => console.error(err));
        }

        function rejectTenant(tenant) {
            fetch(`/tenant_application/${tenant}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.dSuccess,
                        background: '#242830',
                        color: '#fff',
                        confirmButtonColor: '#3085d6',
                    }).finally(() => {
                        location.reload();
                    });
                })
                .catch(err => console.error(err));
        }
    </script>

    <script>
        function confirmAction(message, callback) {
            console.log(message)
            Swal.fire({
                title: message,
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                background: '#242830',
                color: '#fff',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }
    </script>
</div>