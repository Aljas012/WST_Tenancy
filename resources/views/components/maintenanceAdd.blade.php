<div id="maintenanceCarMechanic" class="p-3" style="display: none;">

    <div class="container-fluid">
        <h4 style="font-weight: bold;">Car Maintenance Section</h4>
        <form action="{{ route('maintenance.store') }}" method="POST">
            @csrf
            <div class="row p-3">
                <div class="col">

                    <div class="form-group">
                        <label for="car">Select Car</label>
                        <select class="form-control" name="car_id" id="car">
                            <option style="color:rgb(125, 125, 125); background-color:rgb(40, 50, 75);" selected disabled>Select a Car to Service</option>
                            @foreach ($cars as $car)
                            <option value="{{ $car->id }}" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">
                                {{ $car->plate_number }} - {{ $car->brand }} {{ $car->model }} -  {{ $car->concern }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col">
                    <div class="form-group">
                        <label for="mechanic">Select Mechanic</label>
                        <select class="form-control" name="mechanic_id" id="mechanic">
                            <option style="color:rgb(125, 125, 125);background-color:rgb(40, 50, 75);" selected disabled>Select an Available Mechanic</option>
                            @foreach ($mechanics as $mechanic)
                            <option value="{{ $mechanic->id }}" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">
                                {{ $mechanic->mechanicApplication ? $mechanic->mechanicApplication->name : 'No application available' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-end mt-2" style="gap: .5rem;">
                <button id="closeMaintenanceCarMechanicButton" type="button" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-{{ $cardColor }}" id="sbmtBtn">Submit</button>
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