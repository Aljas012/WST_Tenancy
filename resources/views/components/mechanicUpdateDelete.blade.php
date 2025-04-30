<div id="mechanicUpdateDelete" class="p-3" style="display: none;">

    <div class="container-fluid">
        <h4 style="font-weight: bold;">Update/Delete Section</h4>
        <form id="mechanicUpdateForm" action="" method="POST">
            @csrf
            @method('PUT')

            <div class="row p-3">
                <div class="col">

                    <input type="hidden" name="mechanic_application_id" id="mechanic_application_id">

                    <div class="form-group" style="margin-bottom: 1rem">
                        <label for="fname">Full Name</label>
                        <input type="text" class="form-control" id="fname" value="fname" name="full_name">
                    </div>
                    <div class="form-group">
                        <label for="eaddress">Email Address</label>
                        <input type="email" class="form-control" id="eaddress" name="email" readonly style="background-color: transparent;">
                    </div>
                </div>

                <div class="col">
                    <div class="form-group" style="margin-bottom: 1rem">
                        <label for="pnumber">Phone Number</label>
                        <input type="tel" class="form-control" id="pnumber" name="contact" pattern="[0-9]{1,11}" maxlength="11" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'')" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-2" style="gap: .5rem;">
                <button id="closeMechanicUpdateDeleteButton" type="button" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-{{ $cardColor }}">Update</button>
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
                    Deleting this mechanic's information will remove all associated data and cannot be undone. <br>
                    Please think it twice before deleting.
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

    <script>
        document.getElementById('deleteButton').addEventListener('click', function() {
            const id = document.getElementById('mechanic_application_id').value;

            confirmAction('Delete this mechanic?', function() {
                fetch(`/mechanic/${id}`, {
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