@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Danh sách khảo sát hài lòng</h5>
                        </div>
                    </div>
                    <form>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input type="date" name="search-date" class="form-control form-control-sm"
                                    value="{{ request('search-date', \Carbon\Carbon::today()->toDateString()) }}">
                            </div>
                            <div class="col-md-3">
                                <select name="search-department_id" class="form-control form-control-sm">
                                    <option value="">Tất cả phòng ban</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ request('search-department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="mt-4">
                        <canvas id="departmentRatingsChart" width="400" height="400"></canvas>
                    </div>
                    <div class="table-responsive p-0 mt-4">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mô tả</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày tạo</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Điểm</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($satisfactionSurveys as $index => $survey)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $survey->description }}</p>
                                        </td>
                                        
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $survey->department->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $survey->created_at->format('d/m/Y') }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $survey->level }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$satisfactionSurveys" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('departmentRatingsChart').getContext('2d');
            const departmentNames = @json(array_keys($departmentRatings));
            const departmentRatings = @json(array_values($departmentRatings));

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: departmentNames,
                    datasets: [{
                        label: 'Điểm trung bình',
                        data: departmentRatings,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Điểm trung bình 5 sao cho từng phòng ban'
                        }
                    }
                }
            });
        });
    </script>
@endpush