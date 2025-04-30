@extends('layouts.userTenantPageLayout')
@section('content')
@section('title', 'Dashboard')

<div class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-8">
                <div class="card">

                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Vehicle Table</h4>
                        <p class="card-category">List of all your Vehicle Maintenance Records</p>
                    </div>

                    <div class="card-body">

                        <div class="customTableWrapperMechanics ">
                            <table class="table table-hover">
                                <thead class=" text-primary">
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Brand
                                    </th>
                                    <th>
                                        Model
                                    </th>
                                    <th>
                                        Date Ended
                                    </th>
                                    <th>
                                        Salary
                                    </th>
                                </thead>
                                <tbody>
                                    @forelse($servicedCars as $car)
                                    <tr>
                                        <td>{{ $car['id'] }}</td>
                                        <td>{{ $car['brand'] }}</td>
                                        <td>{{ $car['model'] }}</td>
                                        <td>{{ $car['date_ended'] }}</td>
                                        <td>{{ $car['salary'] }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No serviced cars found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">

                <div class="row">
                    <div class="col">
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">payments</i>
                                </div>
                                <p class="card-category">Total Salary</p>
                                <h3 class="card-title">₱ {{ number_format($totalSalary, 2) }}</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons" style="margin-right: .6rem;">date_range</i> As of <span id="slryDate" style="margin-left: 3.5px;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card card-stats">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">card_giftcard</i>
                                </div>
                                <p class="card-category">Total Incentive</p>
                                <h3 class="card-title">₱ {{ number_format($totalIncentive, 2) }}</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons" style="margin-right: .6rem;">widgets</i> Product-Based Calculation
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function formatDate(hoursAgo) {

        const now = new Date();
        // console.log(now);

        const options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        };
        return now.toLocaleString('en-US', options);
    }

    function updateLast24Hours() {
        const last24Hours = formatDate(24);
        document.getElementById('slryDate').innerText = `${last24Hours}`;
    }

    updateLast24Hours();
</script>

@endsection