@extends('layouts.tenantPageLayout')
@section('content')
@section('title', 'Dashboard')

@php
$colorMapping = [
'purple' => 'primary',
'green' => 'success',
'orange' => 'warning',
'danger' => 'danger',
'azure' => 'info',
];
$cardColor = $colorMapping[$settings->color ?? 'purple'] ?? 'primary';
@endphp

<div class="content">
  <div class="container-fluid">


    <div class="row">
      <div class="col-md-8" id="left-column">
        <!-- Table -->
        <div class="card">

          <div class="card-header card-header-{{ $cardColor }}">
            <h4 class="card-title">Mechanics Record Table</h4>
            <p class="card-category">List of All Mechanics Salary and Incentives</p>
          </div>

          <div class="card-body">

            @include('components.detailedRecords')

            <div id="mechanicsTableWrapper" class="customTableWrapperAdmin scrollbar-{{ $cardColor }}">
              <table class="table table-hover">
                <colgroup>
                  <col width="10%">
                  <col width="40%">
                  <col width="25%">
                  <col width="25%">
                </colgroup>
                <thead class="text-warning">
                  <th>ID</th>
                  <th>Full Name</th>
                  <th>Salary</th>
                  <th>Incentives</th>
                </thead>
                <tbody>
                  @foreach($mechanicSummaries as $summary)
                  <tr class="records-row" style="cursor: pointer;"
                    data-id="{{ $summary['id'] }}"
                    data-name="{{ $summary['name'] }}"
                    data-salary="{{ $summary['total_salary'] }}"
                    data-incentive="{{ $summary['total_incentive'] }}">
                    <td>{{ $summary['id'] }}</td>
                    <td>{{ $summary['name'] }}</td>
                    <td>₱ {{ number_format($summary['total_salary'], 2) }}</td>
                    <td>₱ {{ number_format($summary['total_incentive'], 2) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4" id="right-column">
        <!-- Cards for Total Mechanics, Total Vehicle, Total Maintenance -->
        <div class="row">
          <div class="card card-stats">
            <div class="card-header card-header-{{ $cardColor }} card-header-icon">
              <div class="card-icon">
                <i class="material-icons">people_alt</i>
              </div>
              <p class="card-category">Total Mechanics</p>
              <h3 class="card-title">{{ $totalMechanics }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons" style="margin-right: .6rem;">date_range</i> As of <span id="mchncDate" style="margin-left: 3.5px;"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="card card-stats">
            <div class="card-header card-header-{{ $cardColor }} card-header-icon">
              <div class="card-icon">
                <i class="material-icons">commute</i>
              </div>
              <p class="card-category">Total Vehicle</p>
              <h3 class="card-title">{{ $totalCars }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons" style="margin-right: .6rem;">date_range</i> As of <span id="vhclDate" style="margin-left: 3.5px;"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="card card-stats">
            <div class="card-header card-header-{{ $cardColor }} card-header-icon">
              <div class="card-icon">
                <i class="material-icons">handyman</i>
              </div>
              <p class="card-category">Total Maintenance</p>
              <h3 class="card-title">{{ $totalMaintenance }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons" style="margin-right: .6rem;">date_range</i> As of <span id="mtncnDate" style="margin-left: 3.5px;"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.records-row');
    const detailedDiv = document.getElementById('detailedRecords');
    const nameInput = document.getElementById('mechanicName');
    const closeBtn = document.getElementById('closeDetailedRecords');
    const tableWrapper = document.getElementById('mechanicsTableWrapper');

    const carsTbody = detailedDiv.querySelectorAll('tbody')[0];
    const productsTbody = detailedDiv.querySelectorAll('tbody')[1];

    rows.forEach(row => {
      row.addEventListener('click', function() {
        const mechanicId = this.dataset.id;

        if (tableWrapper) {
          tableWrapper.style.display = 'none';
        }

        if (detailedDiv) {
          detailedDiv.querySelector('#mechanicName').value = name;

          detailedDiv.style.display = 'block';
          detailedDiv.scrollIntoView({
            behavior: 'smooth'
          });

        }
        console.log(mechanicId);

        fetch(`/details/${mechanicId}`)
          .then(response => response.json())
          .then(data => {
            nameInput.value = data.name;

            // console.log(data.cars)

            document.getElementById('mechanic_id').value = data.id;
            document.getElementById('mechanicNameInput').value = data.name;
            document.getElementById('phoneInput').value = data.phone;
            document.getElementById('addressInput').value = data.address;

            document.getElementById('carsDataInput').value = JSON.stringify(data.cars);
            document.getElementById('productsDataInput').value = JSON.stringify(data.products);

            carsTbody.innerHTML = '';
            productsTbody.innerHTML = '';

            // Fill Car table
            data.cars.forEach(car => {
              let salary = car.salary;
              //console.log(salary);

              if (salary === null || salary === undefined || salary === '') {
                salary = 0;
              } else if (typeof salary === 'string') {
                salary = Number(salary.replace(/,/g, ''));
              }
              const formattedSalary = salary.toLocaleString('en-PH', {
                minimumFractionDigits: 2
              });

              const row = `<tr>
                                  <td>${car.id}</td>
                                  <td>${car.car_name}</td>
                                  <td>₱ ${formattedSalary}</td>
                            </tr>`;
              carsTbody.innerHTML += row;
            });

            // Fill Product table
            data.products.forEach(product => {
              let incentive = product.incentive;
              //console.log(incentive);

              if (typeof incentive === 'string') {
                incentive = Number(incentive.replace(/,/g, ''));
              }

              const formattedIncentive = incentive.toLocaleString('en-PH', {
                minimumFractionDigits: 2
              });

              const row = `<tr>
                                <td>${product.id}</td>
                                <td>${product.category}</td>
                                <td>₱ ${formattedIncentive}</td>
                            </tr>`;
              productsTbody.innerHTML += row;
            });

            // Show detailed section
            detailedDiv.style.display = 'block';
          });

      });
    });


    if (closeBtn) {
      closeBtn.addEventListener('click', function() {

        if (detailedDiv) {
          detailedDiv.style.display = 'none';
        }

        if (tableWrapper) {
          tableWrapper.style.display = 'block';
        }
      });
    }


  });
</script>

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
    document.getElementById('mchncDate').innerText = `${last24Hours}`;
    document.getElementById('vhclDate').innerText = `${last24Hours}`;
    document.getElementById('mtncnDate').innerText = `${last24Hours}`;
  }

  updateLast24Hours();
</script>

<script>
  document.addEventListener('DOMContentLoaded', () => {

    new Sortable(document.getElementById('left-column'), {
      group: 'shared',
      animation: 150,
      ghostClass: 'sortable-ghost',
    });

    new Sortable(document.getElementById('right-column'), {
      group: 'shared',
      animation: 150,
      ghostClass: 'sortable-ghost',
    });
  });
</script>

@endsection