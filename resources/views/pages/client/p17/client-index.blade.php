@extends('pages.client.p17.layouts.app')
@section('title', 'Danh sách hộ kinh doanh')
@section('description', 'Danh sách hộ kinh doanh')
@section('keyword', 'Danh sách hộ kinh doanh')
@push('styles')
    <style>
        .w-max-content {
            width: max-content;
        }
        p {
            margin-bottom: 0;
        }
        .table-responsive {
            overflow-x: auto;
            position: relative;
        }

        .table-responsive table {
            white-space: nowrap; /
        }

        .table-responsive th:nth-child(2),
        .table-responsive td:nth-child(2) {
            position: sticky;
            left: 0;
            background-color: #fff;
            z-index: 2;
            border-right: 1px solid #ddd;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .table-responsive thead th:nth-child(2) {
            top: 0;
            z-index: 3;
        }
        .table-responsive.scrolled th:nth-child(2),
        .table-responsive.scrolled td:nth-child(2) {
            background-color: #f8f9fa;
            box-shadow: -6px 5px 15px 2px rgba(0, 0, 0, 0.6);
            -webkit-box-shadow: -6px 5px 15px 2px rgba(0, 0, 0, 0.6);
            -moz-box-shadow: -6px 5px 15px 2px rgba(0, 0, 0, 0.6);
        }
        .table-bordered>:not(caption)>*>* {
            border-width: 0 0px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            var page = 1;
            $('#load-more').on('click', function() {
                page++;
                $.ajax({
                        url: '?page=' + page,
                        type: 'get',
                        beforeSend: function() {
                            $('#load-more').text('Đang tải...');
                        }
                    })
                    .done(function(data) {
                        if (data.trim() == '') {
                            $('#load-more').text('Đã tải hết dữ liệu');
                            $('#load-more').attr("disabled", true);
                            return;
                        }
                        $('#load-more').text('Xem thêm');
                        $('#business-household-data').append(data);
                    })
                    .fail(function() {
                        showToast('Có lỗi xảy ra', 'error');
                        $('#load-more').text('Xem thêm');
                    });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            const $tableContainer = $('.table-responsive');
            $tableContainer.on('scroll', function () {
                if (this.scrollLeft > 0) {
                    $(this).addClass('scrolled');
                } else {
                    $(this).removeClass('scrolled');
                }
            });
        });
    </script>
@endpush

@section('content')
    <section id="business-household" class="business-household mt-5rem mb-5">
        <div class="container ">

            {{-- <form action="{{ route('p17.households.import') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="file" name="file" required>
              <button type="submit">Import</button>
          </form> --}}
            <div class="table-responsive">
                <table class="table table-striped table-bordered  table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>
                                <p class="w-max-content">Số giấy phép</p>
                            </th>
                            <th>
                                <p class="w-max-content">Họ tên chủ hộ kinh doanh</p>
                            </th>
                            <th>
                                <p class="w-max-content">Bảng hiệu</p>
                            </th>
                            <th>
                                <p class="w-max-content">Địa Chỉ</p>
                            </th>
                            <th>
                                <p class="w-max-content">Chi Tiết</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="business-household-data">
                        @include('pages.client.p17.business-household-list')
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    <button id="load-more" class="btn bg-app-gv rounded-pill text-white">Xem thêm</button>
                </div>
            </div>
        </div>

    </section>
@endsection
