@extends('pages.client.p17.layouts.app')
@section('title', 'Kết quả thi')
@section('description', 'Kết quả thi')
@section('keyword', 'Kết quả thi')

@push('styles')
    <style>

    </style>
@endpush

@section('content')
    <section id="result-user-online-exam">
        <div class="container mt-5">
            <div class="row text-center mb-4">
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <div class="circle-score border rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 100px; height: 100px; border-width: 5px;">
                        <div>
                            <h4>{{ $correctAnswersCount }} / {{ $totalQuestions }} </h4>
                            <p>Câu</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-2">
                <div class="card-header">
                    <h5>Tổng kết quả - {{ $quiz->title }}</h5>
                </div>
                <div class="card-body my-2">
                    <div class="row">
                        <canvas id="resultChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li><span style="color: green;">✔</span> Đúng: {{ $correctAnswersCount }}</li>
                            <li><span style="color: red;">✖</span> Sai: {{ $incorrectAnswersCount }}</li>
                            <li><span style="color: orange;">⚪</span> Chưa trả lời: {{ $notAnsweredCount }}</li>
                        </ul>
                        <p>Tổng số câu hỏi: {{ $totalQuestions }}</p>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('p17.list.competitions.exams.client') }}" class="btn btn-secondary">Trang chủ</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
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
@endpush

