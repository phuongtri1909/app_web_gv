@extends('pages.client.p17.layouts.app')

@if(Route::currentRouteName() == 'p17.list.surveys.client')
    @section('title', 'Khảo sát trực tuyến')
    @section('description', 'Khảo sát trực tuyến')
    @section('keyword', 'Khảo sát trực tuyến')
@elseif(Route::currentRouteName() == 'p17.list.competitions.exams.client')
    @section('title', 'Thi trực tuyến')
    @section('description', 'Thi trực tuyến')
    @section('keyword', 'Thi trực tuyến')
@endif

@push('styles')
    <style>
        #home-online-exams {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        .banner {
            display: flex;
            align-items: center;
            color: white;
            border-radius: 10px 10px 0 0;
            width: 100%;
            height: auto;
        }

        .banner img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 15px;
        }

        .banner .title {
            flex: 1;
            font-size: 24px;
            font-weight: bold;
        }

        .banner .status {
            padding: 5px 15px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            color: white;
        }

        .status.ongoing {
            background-color: #5dce00;
            color: #ffffff;
        }

        .status.upcoming {
            background-color: #3b67dc;
            color: #ffffff;
        }

        .status.completed {
            background-color: #99000e;
            color: #fff;
        }

        .filters {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .filter {
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 6px;
            border: 1px solid #f1f1f1;
        }

        .filter:focus {
            border: 1px solid #f1f1f1;
        }

        .exam-list {
            margin-top: 20px;
        }

        .exam-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0px 0px 15px 0px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            height: auto;
            flex-wrap: wrap;
        }

        .exam-item a {
            width: 100%;
        }

        .exam-item .banner {
            position: static;
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }

        .exam-item .banner img {
            width: 100%;
            max-width: 900px;
            height: auto;
            margin: 0 auto;
            object-fit: cover;
        }

        .exam-item .details {
            flex: 1;
            margin: 0;
            position: static;
            text-align: left;
            margin-left: 6px;
        }

        .exam-item .details .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #ef0c0c;
        }

        .exam-item .details .date {
            font-size: 14px;
            color: #555;
        }

        .exam-item .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
            width: 90px;
            float: right;
        }

        .form-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .back-btn {
            background-color: #fff;
            border: 1px solid #007bff;
            color: #007bff;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
        }

        .back-btn:hover {
            color: #007bff;
            border-color: #0056b3;
            transform: translateY(-2px);
        }

        .back-icon {
            margin-right: 8px;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .filters {
                flex-direction: column;
                gap: 10px;
            }

            .exam-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .exam-item .details {
                text-align: left;
            }

            .exam-item .status {
                align-self: flex-end;
            }
        }

        @media (max-width: 576px) {

            .banner .title {
                font-size: 20px;
            }

            .exam-item .details .title {
                font-size: 16px;
            }

            .exam-item .details .date {
                font-size: 12px;
            }

            .exam-item .status {
                font-size: 12px;
            }
        }

        .user-greeting {
            font-size: 1.2rem;
            color: #4CAF50;
            font-weight: bold;
            margin-left: 15px;
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            const $filterSelect = $('.filters select');
            const $examItems = $('.exam-item');

            $filterSelect.on('change', function() {
                const filterStatus = $(this).val();

                $examItems.each(function() {
                    $(this).toggle(filterStatus === 'all' || $(this).data('status') ===
                        filterStatus);
                });
            });
        });
    </script>
    <script>
        function goBack() {
            $.ajax({
                    url: '/client/p17/forget-session',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(function(response) {
                    window.history.back();
                })
                .catch(function(error) {
                    if (error.responseJSON) {
                        showToast(error.responseJSON.message, 'error');
                    } else {
                        showToast('Có lỗi xảy ra. Vui lòng thử lại sau.', 'error');
                    }
                    window.history.back();
                });
        }
    </script>
@endpush

@section('content')
    <div class="form-actions my-2">
        <button type="button" onclick="goBack()" class="back-btn">
            <i class="fa-solid fa-arrow-left back-icon"></i> Quay lại
        </button>
        @if (Session::has('user_full_name'))
            <p class="user-greeting">
                <i class="fa-solid fa-user"></i> Chào, {{ Session::get('user_full_name') }}!
            </p>
        @endif
    </div>
    <section id="home-online-exams">
        <div class="filters">
            <select class="filter select">
                <option value="all">Tất cả</option>
                <option value="ongoing">Đang thi</option>
                <option value="upcoming">Sắp diễn ra</option>
                <option value="completed">Đã kết thúc</option>
            </select>
        </div>
        <div class="exam-list">
            @forelse ($competitions as $competition)
                <div class="exam-item"
                    data-status="{{ strtolower(str_replace(' ', '-', $competition->calculated_status_key)) }}">
                    @if ($competition->calculated_status_key == 'completed' || $competition->calculated_status_key == 'upcoming')
                        <a href="javascript:void(0)">
                            <div class="exam-link disabled">
                                <div class="banner">
                                    <img src="{{ $competition->banner ? asset($competition->banner) : 'https://via.placeholder.com/360x203' }}"
                                        alt="{{ $competition->title }}" loading="lazy" class="img-fluid">
                                </div>
                                <div class="details">
                                    <div class="title">{{ $competition->title }}</div>
                                    <div class="date">
                                        {{ \Carbon\Carbon::parse($competition->start_date)->format('d/m/Y H:i') }}
                                        <span>-</span>
                                        {{ \Carbon\Carbon::parse($competition->end_date)->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div
                                    class="status {{ strtolower(str_replace(' ', '-', $competition->calculated_status_key)) }}">
                                    {{ $competition->calculated_status }}
                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('p17.list.quiz.client', ['competitionId' => $competition->id]) }}"
                            class="exam-link">
                            <div class="banner">
                                <img src="{{ $competition->banner ? asset($competition->banner) : 'https://via.placeholder.com/360x203' }}"
                                    alt="{{ $competition->title }}" loading="lazy" class="img-fluid">
                            </div>
                            <div class="details">
                                <div class="title">{{ $competition->title }}</div>
                                <div class="date">
                                    {{ \Carbon\Carbon::parse($competition->start_date)->format('d/m/Y H:i') }}
                                    <span>-</span>
                                    {{ \Carbon\Carbon::parse($competition->end_date)->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <div
                                class="status {{ strtolower(str_replace(' ', '-', $competition->calculated_status_key)) }}">
                                {{ $competition->calculated_status }}
                            </div>
                        </a>
                    @endif
                </div>
            @empty
                <p class="text-center">
                    @if(Route::currentRouteName() == 'p17.list.surveys.client')
                        Không có khảo sát nào đang diễn ra hoặc sắp diễn ra.
                    @elseif(Route::currentRouteName() == 'p17.list.competitions.exams.client')
                        Không có kỳ thi nào đang diễn ra hoặc sắp diễn ra.
                    @endif
                </p>
            @endforelse
        </div>
    </section>
@endsection
