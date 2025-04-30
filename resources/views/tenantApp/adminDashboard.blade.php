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
        <!-- Table (Mechanics Record Table) -->
        <div class="card">
          <div class="card-header card-header-{{ $cardColor }}">
            <h4 class="card-title">Mechanics Record Table</h4>
            <p class="card-category">List of All Mechanics Salary and Incentives</p>
          </div>
          <div class="card-body">
            <div class="customTableWrapperAdmin scrollbar-{{ $cardColor }}">
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
                  <tr>
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