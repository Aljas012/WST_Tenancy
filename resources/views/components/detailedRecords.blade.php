<div id="detailedRecords" style="display: none; padding: 1rem 0 0 0">

    <div class="container-fluid">
        <h4 style="font-weight: bold;">Detailed Record Section</h4>
        <form id="pdfForm" action="{{ route('generate.pdf') }}" method="POST">
            @csrf

            <input type="hidden" id="mechanic_id" name="mechanic_id">
            <input type="hidden" name="cars_data" id="carsDataInput">
            <input type="hidden" name="products_data" id="productsDataInput">
            <input type="hidden" id="mechanicNameInput" name="mechanic_name">
            <input type="hidden" id="phoneInput" name="phone">
            <input type="hidden" id="addressInput" name="address">

            <div class="row" style="padding: 1rem 1rem 0 1rem;">

                <div class="col-md-4">
                    <label for="mechanicName">Full Name</label>
                    <input type="text" class="form-control" id="mechanicName" name="name" readonly style="background-color: transparent;">
                </div>
            </div>

            <div class="row" style="padding: 1rem 1rem;">
                <div class="col-6">
                    <p>Car Worked</p>

                    <div class="customTableWrapperDetails scrollbar-{{ $cardColor }}">
                        <table class="table table-hover">
                            <colgroup>
                                <col width="10%">
                                <col width="45%">
                                <col width="45%">
                            </colgroup>
                            <thead>
                                <th>ID</th>
                                <th>Car</th>
                                <th>Salary</th>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-6">
                    <p>Products Incentives</p>

                    <div class="customTableWrapperDetails scrollbar-{{ $cardColor }}">
                        <table class="table table-hover">
                            <colgroup>
                                <col width="10%">
                                <col width="45%">
                                <col width="45%">
                            </colgroup>
                            <thead>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Incentive</th>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row" style="padding: 0 1rem;">

            </div>

            <div class="d-flex justify-content-end mt-2" style="gap: .5rem;">
                <button id="closeDetailedRecords" type="button" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-{{ $cardColor }}" id="pdfBtn">Convert to PDF</button>
            </div>
        </form>

    </div>

    <script>
        document.getElementById('pdfBtn').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Convert to PDF?',
                text: 'Approving this will remove the Data in the System',
                icon: 'warning',
                background: '#242830',
                color: '#fff',
                showCancelButton: true,
                confirmButtonText: 'Yes, convert it!',
                cancelButtonText: 'No, cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('pdfForm').submit();

                    setTimeout(() => {
                        location.reload();
                    }, 1500); 

                } else {

                    Swal.fire({
                        title: 'Cancelled',
                        text: 'Conversion Cancelled :>',
                        icon: 'info',

                        background: '#242830',
                        color: '#fff',
                    });
                }
            });
        });
    </script>
</div>