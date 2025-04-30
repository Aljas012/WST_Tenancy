<div id="maintenanceUpdateDelete" class="p-3" style="display: none;">

    <div class="container-fluid">
        <h4 style="font-weight: bold;">Maintenance Update/Delete Section</h4>
        <form id="updtMaintenanceForm" action="" method="POST">
            @csrf
            @method('PUT')

            <div class="row" style="padding: 1rem 1rem 0 1rem;">
                <div class="col">

                    <input type="hidden" name="maintenanceUpdtDltId" id="maintenanceUpdtDltId">

                    <div class="form-group" style="margin-bottom: 1rem">
                        <label for="brand">Plate Number</label>
                        <input type="text" class="form-control" name="pNumber" id="pNumber" readonly style="background-color: transparent;">
                    </div>

                    <div class="form-group" style="margin-bottom: 1rem">
                        <label for="concern">Concern</label>
                        <textarea type="text" class="form-control" name="concern" rows="1" id="concern"></textarea>
                    </div>

                </div>

                <div class="col">

                    <div class="form-group" style="margin-bottom: 1rem">
                        <label for="brand">Mechanic</label>
                        <input type="text" class="form-control" name="mechanic" id="mechanic" readonly style="background-color: transparent;">
                    </div>

                    <div class="form-group" style="margin-bottom: 1rem">
                        <label for="brand">Started</label>
                        <input type="text" class="form-control" name="fixStart" id="fixStart" readonly style="background-color: transparent;">
                    </div>

                </div>

            </div>

            <div class="row" style="padding: 0 1rem;">
                <div class="col-2">
                    <div class="form-group" style="margin-bottom: 1rem">
                        <label for="brand">Salary</label>
                        <input type="text" class="form-control" name="salary" id="salary">
                    </div>
                </div>
            </div>

            <div class="row" style="padding: 0 1rem;">
                <div class="col">
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea type="text" class="form-control" name="note" rows="3" id="note"></textarea>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-end mt-2" style="gap: .5rem;">
                <button id="closeMaintenanceUpdateDeleteButton" type="button" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-{{ $cardColor }}" id="dnBtn">Done</button>
            </div>
        </form>

        <div style="margin-top: 1.8rem;">
            <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                <hr style="flex: 0.1; border: none; border-top: 1px solid rgb(255, 39, 60); margin: 0;">
                <p style="margin: 0 1rem; color: rgb(255, 39, 60); font-weight: bold;">Danger Zone</p>
                <hr style="flex: 1.5; border: none; border-top: 1px solid rgb(255, 39, 60); margin: 0;">
            </div>

            <div>
                <h5 style="color: rgb(255, 59, 79); font-size: 16px">
                    Deleting this maintenance record will remove all associated data and cannot be undone.<br>
                    Please think twice before proceeding.
                </h5>
            </div>
            <button class="btn btn-danger" id="deleteButton">Delete</button>
        </div>

    </div>

    <script>
        function confirmAction(message, callback) {
            console.log(message)
            Swal.fire({
                title: message,
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

    <script>
        const salaryInput = document.getElementById('salary');

        salaryInput.addEventListener('input', function() {
            let value = this.value.replace(/[^0-9]/g, '');
            value = value.slice(0, 6); 
            this.value = Number(value).toLocaleString();
        });
    </script>

    <script>
        document.getElementById('deleteButton').addEventListener('click', function() {
            const id = document.getElementById('maintenanceUpdtDltId').value;

            confirmAction('Delete this maintenance?', function() {
                fetch(`/maintenance/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
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
            });
        });
    </script>

</div>