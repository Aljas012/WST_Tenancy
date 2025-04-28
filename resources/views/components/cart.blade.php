<div id="cartShow" class="p-3" style="display: none;">

    <div class="container-fluid">
        <h4 style="font-weight: bold;">Order Section</h4>
        <form id="checkoutForm" action="{{ route('order.store') }}" method="POST">
            @csrf

            <div class="row" style="padding: 1rem 1rem 0;">

                <div class="col">

                    <div class="form-group">
                        <label for="car">Select Maintenance</label>
                        <select class="form-control" name="car_id" id="car">
                            <option style="color:rgb(125, 125, 125); background-color:rgb(40, 50, 75);" selected disabled>Select a Maintenance for the Order</option>
                            @foreach ($maintenances as $maintenance)
                            <option value="{{ $maintenance->id }}" style="color:rgb(195, 195, 195); background-color:rgb(40, 50, 75);">
                                {{ $maintenance->car->plate_number }}, {{ $maintenance->mechanic->mechanicApplication->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col"></div>

            </div>

            <div class="row" style="padding: 1rem;">

                <div class="col">
                    <table class="table">
                        <colgroup>
                            <col width="10%">
                            <col width="30%">
                            <col width="30%">
                            <col width="10%">
                            <col width="10%">
                        </colgroup>
                        <thead class="text-warning">
                            <th>Quantity</th>
                            <th>Product Number</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Total</th>
                        </thead>
                        <tbody>
                            <!-- Cart products will be appended here -->
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="d-flex justify-content-end mt-2" style="gap: .5rem;">
                <button id="clsCartBtn" type="button" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-primary" id="chckOutBtn">Check Out</button>
            </div>
        </form>

    </div>

</div>