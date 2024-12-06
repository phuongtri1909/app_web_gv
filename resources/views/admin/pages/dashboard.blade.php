@extends('admin.layouts.app')

@push('styles-admin')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.css">
@endpush

@section('content-auth')
    <div class="">
        <h2>Bảng điều khiển</h2>
        <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-3">
            <div class="col-md-4">
                <label for="period" class="form-label">Chọn khoảng thời gian:</label>
                <select class="form-select" name="period" id="period" onchange="this.form.submit()">
                    <option value="day" {{ $period == 'day' ? 'selected' : '' }}>Ngày</option>
                    <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Tuần</option>
                    <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Tháng</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="month" class="form-label">Chọn tháng:</label>
                <select class="form-select" name="month" id="month" onchange="this.form.submit()">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label for="year" class="form-label">Chọn năm:</label>
                <select class="form-select" name="year" id="year" onchange="this.form.submit()">
                    @for ($y = 2020; $y <= Carbon\Carbon::now()->year; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </form>
        <div class="row">
            <div class="col-12 col-md-6">
                <canvas id="businessMemberRegistrationsChart"></canvas>
                <p>Số doanh nghiệp đăng ký trong khoảng thời gian này: {{ $businessMemberRegistrations['current'] }}</p>
                <p>Tỷ lệ thay đổi so với khoảng thời gian trước: {{ $businessMemberPercentageChange }}%</p>
            </div>
            <div class="col-12 col-md-6">
                <canvas id="businessRegistrationsChart"></canvas>
                <p>Số doanh nghiệp trong khoảng thời gian này: {{ $businessRegistrations['current'] }}</p>
                <p>Tỷ lệ thay đổi so với khoảng thời gian trước: {{ $businessPercentageChange }}%</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script>
        var ctx1 = document.getElementById('businessMemberRegistrationsChart').getContext('2d');
        var businessMemberRegistrationsChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Khoảng thời gian trước', 'Khoảng thời gian này'],
                datasets: [{
                    label: 'Đăng ký thành viên doanh nghiệp',
                    data: [{{ $businessMemberRegistrations['previous'] }}, {{ $businessMemberRegistrations['current'] }}],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx2 = document.getElementById('businessRegistrationsChart').getContext('2d');
        var businessRegistrationsChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Khoảng thời gian trước', 'Khoảng thời gian này'],
                datasets: [{
                    label: 'Đăng ký doanh nghiệp',
                    data: [{{ $businessRegistrations['previous'] }}, {{ $businessRegistrations['current'] }}],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush