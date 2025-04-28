<div id="inventoryAdd" class="p-3" style="display: none;">

    <div class="container-fluid">
        <h4 style="font-weight: bold;">Add Product Section</h4>
        <form action="{{ route('inventory.store') }}" method="POST">
            @csrf
            <div class="row" style="padding: 1rem 1rem 0 1rem;">

                <div class="col-md-5">

                    <div class="form-group" style="margin: 3.3px;">
                        <label class="bmd-label-floating" for="category">Category</label>
                        <select class="form-control" name="category" id="category">
                            <option style="color:rgb(125, 125, 125); background-color:rgb(40, 50, 75);" selected disabled>Select Product Category</option>

                            <option value="Batteries" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Batteries</option>
                            <option value="Brakes" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Brakes</option>
                            <option value="Clutch System" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Clutch System</option>
                            <option value="Filters" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Filters</option>
                            <option value="Lubricants" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Lubricants</option>
                            <option value="Tires" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">Tires</option>

                        </select>
                    </div>

                </div>

                <div class="col-md-5">

                    <div class="form-group" style="margin-bottom: 1rem">
                        <label class="bmd-label-floating" for="part_number">Part Number</label>
                        <input type="text" class="form-control" name="part_number" id="part_number">
                    </div>

                </div>

                <div class="col-md-2">

                    <div class="form-group" style="margin-bottom: 1rem">
                        <label class="bmd-label-floating" for="quantity">Quantity</label>
                        <input
                            type="text"
                            class="form-control"
                            name="quantity"
                            id="quantity"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                    </div>

                </div>

            </div>

            <div class="row" style="padding: 0 1rem;">

                <div class="col-md-10">

                    <div class="form-group" style="margin-bottom: 1rem">
                        <label class="bmd-label-floating" for="description">Description</label>
                        <input type="text" class="form-control" name="description" id="description">
                    </div>

                </div>

                <div class="col-md-2">

                    <div class="form-group" style="margin-bottom: 1rem">
                        <label class="bmd-label-floating" for="price">Price</label>
                        <input
                            type="text"
                            class="form-control"
                            name="price"
                            id="price"
                            oninput="formatThousands(this)"
                            maxlength="7">
                    </div>

                </div>

            </div>

            <div class="d-flex justify-content-end mt-2" style="gap: .5rem;">
                <button id="closeinventoryAdd" type="button" class="btn btn-secondary">Close</button>
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

    <script>
        function formatThousands(input) {
            let rawValue = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric chars
            if (rawValue.length === 0) {
                input.value = '';
                return;
            }

            input.value = parseInt(rawValue, 10).toLocaleString('en-US');
        }
    </script>
    
</div>