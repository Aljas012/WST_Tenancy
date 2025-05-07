<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mechanic Report</title>
    <style>
        .no-margin {
            margin: 0 !important;
            padding: 0 !important;
        }

        p {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>

</head>

<body>
    <div class="container">

        <div style="text-align: right; font-size: 12px; margin-bottom: 10px;">
            {{ $dateGenerated }}
        </div>

        <div class="no-margin">
            <p><strong style="font-size: 14px;">Full Name:</strong> {{ $mechanicName }} </p>
            <p><strong style="font-size: 14px;">Phone Number:</strong> {{ $phone }} </p>
            <p><strong style="font-size: 14px;">Address:</strong> {{ $address }} </p>
        </div>

        <div>
            <h3></h3>
        </div>

        <div>
            <h4>Cars Fixed</h4>
            <table cellpadding="5">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Car</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalSalary = 0;
                    @endphp
                    @foreach ($cars as $car)
                        @php
                        $salary = (float) str_replace(',', '', $car['salary']);
                        $totalSalary += $salary;
                    @endphp
                    <tr>
                        <td>{{ $car['id'] }}</td>
                        <td>{{ $car['car_name'] }}</td>
                        <td>₱ {{ number_format($salary, 2, '.', ',') }}</td>
                    </tr>
                    @endforeach
                    <tr style="font-size: 14px;">
                        <td colspan="2" style="text-align: right;"><strong>Total Salary:</strong></td>
                        <td><strong>₱ {{ number_format($totalSalary, 2, '.', ',') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div>
            <h4>Incentivized Products</h4>
            <table cellpadding="5">
                <thead>
                    <tr style="font-size: 14px;">
                        <th>ID</th>
                        <th>Category</th>
                        <th>Incentive</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalIncentive = 0;
                    @endphp
                    @foreach ($products as $product)
                        @php
                        $incentive = (float) str_replace(',', '', $product['incentive']);
                        $totalIncentive += $incentive;
                        @endphp
                        <tr>
                            <td>{{ $product['id'] }}</td>
                            <td>{{ $product['category'] }}</td>
                            <td>₱ {{ number_format($incentive, 2, '.', ',') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong>Total Incentives:</strong></td>
                        <td><strong>₱ {{ number_format($totalIncentive, 2, '.', ',') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>