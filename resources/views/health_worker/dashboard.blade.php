
@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_card.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@latest/dist/chartjs-adapter-moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
       #forecastChart, #status_chart, #yearly_period {
            width: 100%;
            height: 430px;
        }
        #forecastChart {
            width: 100% !important; /* Ensures it uses full width */
            height: 430px !important; /* Fixes the height */
        }
        .forecast-container {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
        }
        .card {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .stat-card {
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 80%);
            transform: rotate(30deg);
        }
        .stat-icon {
            font-size: 48px;
            opacity: 0.2;
            position: absolute;
            bottom: -10px;
            right: 10px;
        }
        .chart-container {
            height: 400px;
        }
        .btn-group .btn {
            @apply px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
        }
        .btn-group .btn.active {
            @apply text-white bg-indigo-600 border-indigo-600 hover:bg-indigo-700;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            @apply min-w-full divide-y divide-gray-200;
        }
        th {
            @apply px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider;
        }
        td {
            @apply px-6 py-4 whitespace-nowrap text-sm text-gray-500;
        }
        tr:hover {
            @apply bg-gray-50;
        }
    </style>
@endsection

@section('contents')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 id="greeting" class="mb-3 mb-md-0">Welcome back {{ Auth::user()->last_name ?? 'User' }}!</h4>
        </div>
    </div>

    <div class="stretch-card">
        <div class="row flex-grow">
            <!-- Assigned Feminine Card -->
            <div class="col-lg-3 col-sm-6">
                <div class="card-box shadow-sm" style="background-color: #FD5DA8;">
                    <div class="inner">
                        <h3 id="assigned_feminine_count">{{ $assign_feminine_count ?? 0 }}</h3>
                        <p>Assigned Female</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-user-tag"></i>
                    </div>
                    <a href="{{ URL::to('health-worker/feminine-list') }}" class="card-box-footer">
                        View More <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Regular Period Card -->
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-success shadow-sm">
                    <div class="inner">
                        <h3 id="active_feminine_count">{{ $count['active_feminine_count'] ?? 0 }}</h3>
                        <p>Regular Period</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <a href="{{ URL::to('health-worker/feminine-list') }}" class="card-box-footer">
                        View More <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Irregular Period Card -->
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-info shadow-sm">
                    <div class="inner">
                        <h3 id="inactive_feminine_count">{{ $count['inactive_feminine_count'] ?? 0 }}</h3>
                        <p>Irregular Period</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-user-tag"></i>
                    </div>
                    <a href="{{ URL::to('health-worker/feminine-list') }}" class="card-box-footer">
                        View More <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Forecast Section -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4">
                <h2 class="text-primary">Feminine Health Forecast</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-2 mb-sm-0">12-Month Forecast</h5>
                            <div class="btn-group" role="group" aria-label="Timeframe">
                                <button type="button" class="btn btn-outline-primary" data-timeframe="3">3 Months</button>
                                <button type="button" class="btn btn-outline-primary" data-timeframe="6">6 Months</button>
                                <button type="button" class="btn btn-outline-primary active" data-timeframe="12">12 Months</button>
                            </div>
                        </div>
                        <canvas id="forecastChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Current Month Overview</h5>
                        <div id="currentMonthStats"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Breakdown Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Monthly Breakdown</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Regular</th>
                                        <th>Irregular</th>
                                        <th>Potentially Menopause</th>
                                        <th>Potentially Pregnant</th>
                                    </tr>
                                </thead>
                                <tbody id="monthlyBreakdown"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feminine Status Chart Section -->
        <div class="row mt-5">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Feminine Status Chart</h5>
                        <div id="status_chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/amcharts/amcharts.com_lib_5_index.js') }}"></script>
    <script src="{{ asset('assets/amcharts/amcharts.com_lib_5_percent.js') }}"></script>
    <script src="{{ asset('assets/amcharts/amcharts.com_lib_5_xy.js') }}"></script>
    <script src="{{ asset('assets/amcharts/amcharts.com_lib_5_themes_Animated.js') }}"></script>
    <script src="{{ asset('assets/js/health_worker/pie_chart.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const greetingElement = document.getElementById('greeting');
        const currentTime = new Date().getHours();
        let greeting = 'Good morning';

        if (currentTime >= 6 && currentTime < 12) {
            greeting = 'Good morning';
        } else if (currentTime >= 12 && currentTime < 18) {
            greeting = 'Good afternoon';
        } else {
            greeting = 'Good evening';
        }

        const userName = '{{ Auth::user()->first_name }}';
        greetingElement.textContent = `${greeting} ${userName} welcome back! 👋`;
    });


    
    //prediction chart//
    document.addEventListener('DOMContentLoaded', function() {
    var forecastData = @json($forecastData);
    var ctx = document.getElementById('forecastChart').getContext('2d');
    var chart;

   function initChart(data, months) {
    if (chart) {
        chart.destroy();
    }

    chart = new Chart(ctx, {
        type: 'line', // Change the chart type to 'line'
        data: {
            labels: data.labels.slice(0, months),
            datasets: [
                {
                    label: 'Regular',
                    data: data.datasets.regular.slice(0, months),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)', // Add fill color for the area
                    borderColor: 'rgba(75, 192, 192, 1)', // Line color
                    fill: true, // Fill the area beneath the line
                    tension: 0.3 // Smoothing effect for the line
                },
                {
                    label: 'Irregular',
                    data: data.datasets.irregular.slice(0, months),
                    backgroundColor: 'rgba(255, 159, 64, 0.5)', 
                    borderColor: 'rgba(255, 159, 64, 1)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Potentially Menopause',
                    data: data.datasets.at_risk.slice(0, months),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)', 
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Potentially Pregnant',
                    data: data.datasets.pregnant.slice(0, months),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', 
                    borderColor: 'rgba(54, 162, 235, 1)',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true, // Keep the chart responsive
            maintainAspectRatio: false, // Allow the chart to scale with its container
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}



    function updateCurrentMonthStats(data) {
        var currentMonth = data.monthlyData[0];
        var statuses = currentMonth.statuses;
        var total = Object.values(statuses).reduce((a, b) => a + b, 0);

        var html = `
            <div class="row">
                ${Object.entries(statuses).map(([status, count]) => `
                    <div class="col-6 mb-3">
                        <div class="card bg-light">
                            <div class="card-body p-2">
                                <h6 class="card-title text-${getStatusColor(status)}">${capitalizeFirstLetter(status)}</h6>
                                <p class="card-text h4">${count}</p>
                                <p class="card-text text-muted">${((count / total) * 100).toFixed(1)}%</p>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;

        document.getElementById('currentMonthStats').innerHTML = html;
    }

    function updateMonthlyBreakdown(data) {
        var html = data.monthlyData.map(month => `
            <tr>
                <td>${month.month}</td>
                <td>${month.statuses.regular}</td>
                <td>${month.statuses.irregular}</td>
                <td>${month.statuses.at_risk}</td>
                <td>${month.statuses.pregnant}</td>
            </tr>
        `).join('');

        document.getElementById('monthlyBreakdown').innerHTML = html;
    }

    function getStatusColor(status) {
        switch(status) {
            case 'regular': return 'success';
            case 'irregular': return 'warning';
            case 'at_risk': return 'danger';
            case 'pregnant': return 'info';
            default: return 'secondary';
        }
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Initialize chart and stats
    initChart(forecastData, 12);
    updateCurrentMonthStats(forecastData);
    updateMonthlyBreakdown(forecastData);

    // Timeframe button functionality
    document.querySelectorAll('[data-timeframe]').forEach(button => {
        button.addEventListener('click', function() {
            var months = parseInt(this.getAttribute('data-timeframe'));
            initChart(forecastData, months);
            document.querySelectorAll('[data-timeframe]').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
    </script>
@endsection








