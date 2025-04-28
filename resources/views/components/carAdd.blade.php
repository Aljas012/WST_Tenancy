<div id="addCar" class="p-3" style="display: none;">

    <div class="container-fluid">
        <h4 style="font-weight: bold;">Add Car Section</h4>
        <form action="{{ route('car.store') }}" method="POST">
            @csrf
            <div class="row p-3">
                <div class="col">

                    <div class="form-group" style="margin-bottom: 1rem">
                        <label class="bmd-label-floating" for="brand">Brand</label>
                        <input type="text" class="form-control" name="brand" id="brand">
                    </div>
                    <div class="form-group">
                        <label class="bmd-label-floating" for="plate_number">Plate Number</label>
                        <input type="text" class="form-control" name="plate_number" id="plate_number">
                    </div>

                </div>

                <div class="col">
                    <div class="form-group" style="margin-bottom: 1.2rem">
                        <label class="bmd-label-floating" for="model">Model</label>
                        <input type="text" class="form-control" name="model" id="model">
                    </div>
                    <div class="form-group">
                        <label class="bmd-label-floating" for="concern">Concern</label>
                        <textarea type="text" class="form-control" name="concern" rows="1" id="concern"></textarea>
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-end mt-2" style="gap: .5rem;">
                <button id="closeAddCarButton" type="button" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-{{ $cardColor }}" id="approveButton">Submit</button>
            </div>
        </form>

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
</div>