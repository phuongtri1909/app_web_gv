@extends('pages.client.p17.layouts.app')
@section('title', 'Kết quả ' . ($type === 'competition' ? 'thi trực tuyến' : 'khảo sát trực tuyến'))
@section('description', 'Kết quả ' . ($type === 'competition' ? 'thi trực tuyến' : 'khảo sát trực tuyến'))
@section('keyword', 'Kết quả ' . ($type === 'competition' ? 'thi trực tuyến' : 'khảo sát trực tuyến'))

@push('styles')
    <style>
        .circle-score {
            width: 100px;
            height: 100px;
            border-width: 5px;
        }
    </style>
@endpush

@section('content')
    <section id="result-user-online-exam">
        <div class="container mt-5">
            @if ($type === 'competition')
                <div class="row justify-content-center text-center mb-4">
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <div class="circle-score border rounded-circle d-flex flex-column align-items-center justify-content-center shadow-sm">
                            <h4 class="mb-1 text-primary">{{ $correctAnswersCount }} / {{ $totalQuestions }}</h4>
                            <p class="mb-0 text-muted">Câu</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="mt-4 px-4 py-3">
                <h5 class="mb-4 text-center text-uppercase">
                    {{ $type === 'competition' ? 'Tổng kết quả - ' . $quiz->title : $quiz->title }}
                </h5>
                @if ($type === 'competition')
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <canvas id="resultChart"></canvas>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><span style="color: green;">✔</span> <strong>Đúng:</strong> {{ $correctAnswersCount }}</li>
                                <li><span style="color: red;">✖</span> <strong>Sai:</strong> {{ $incorrectAnswersCount }}</li>
                                <li><span style="color: orange;">⚪</span> <strong>Chưa trả lời:</strong> {{ $notAnsweredCount }}</li>
                            </ul>
                            <p class="text-muted">Tổng số câu hỏi: <strong>{{ $totalQuestions }}</strong></p>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <img src="{{ asset('images/p17/cm.jpg') }}" alt="Congratulations" class="img-fluid mt-3 mb-3 rounded">
                        <h4 class="text-success">Chúc mừng bạn đã hoàn thành khảo sát!</h4>
                    </div>
                @endif
                <div class="text-center mt-4">
                    <a href="{{ route($type === 'competition' ? 'p17.list.competitions.exams.client' : 'p17.list.surveys.client') }}" class="text-primary font-weight-bold">
                        Quay lại {{ $type === 'competition' ? 'cuộc thi' : 'khảo sát' }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @if ($type === 'competition')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('resultChart').getContext('2d');
            const correctCount = {{ $correctAnswersCount }};
            const incorrectCount = {{ $incorrectAnswersCount }};
            const unansweredCount = {{ $notAnsweredCount }};

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Đúng', 'Sai', 'Chưa trả lời'],
                    datasets: [{
                        label: 'Kết quả',
                        data: [correctCount, incorrectCount, unansweredCount],
                        backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        </script>
    @endif
@endpush
