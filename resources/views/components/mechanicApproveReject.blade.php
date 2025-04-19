<div id="mechanicApproveReject" class="p-3" style="display: none;">

    <div class="container-fluid">
        <form action="{{ route('mechanic.store') }}" method="POST">
        @csrf
            <div class="row p-3">
                <div class="col">
                    <input type="hidden" name="mechanic_application_id" id="mechanic_application_id">

                    <div class="form-group" style="margin-bottom: 1rem">
                        <label for="fname">Full Name</label>
                        <input type="text" class="form-control" id="fname">
                    </div>
                    <div class="form-group">
                        <label for="eaddress">Email Address</label>
                        <input type="email" class="form-control" id="eaddress">
                    </div>
                </div>

                <div class="col">
                    <div class="form-group" style="margin-bottom: 1rem">
                        <label for="pnumber">Phone Number</label>
                        <input type="text" class="form-control" id="pnumber">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-2" style="gap: .5rem;">
                <button id="closeMechanicApproveRejectButton" type="button" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-primary">Approve</button>
            </div>
        </form>

    </div>

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