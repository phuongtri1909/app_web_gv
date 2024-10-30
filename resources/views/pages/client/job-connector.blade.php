@extends('layouts.app')
@section('title', 'Kết nối việc làm')
@section('description', 'Kết nối việc làm')
@section('keyword', 'Kết nối việc làm')
@push('styles')
    <style>
        .info-section {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .info-section.active {
            display: block;
            opacity: 1;
        }

        .job-listing, .applicant-listing {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .job-listing h5, .applicant-listing h5 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .job-listing p, .applicant-listing p {
            margin: 5px 0;
        }


        .click-btn {
            margin: 10px;
            width: 150px;
            display: flex;
            height: 40px;
            justify-content: center;
            align-items: center;
            margin: 0.5rem;
            line-height: 35px;
            border: 1px solid;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            color: #333;
            text-decoration: none;
            transition: all 0.35s;
            box-sizing: border-box;
        }

        .btn-style702 {
            position: relative;
            border-color: transparent;
            color: #333;
        }

        .btn-style702::before,
        .btn-style702::after {
            height: 100%;
            position: absolute;
            top: 0;
            transition: all 0.3s;
            content: "";
        }

        .btn-style702::before {
            width: 100%;
            left: 0;
            border-radius: 5px;
            background-color: #716eef;
            z-index: -1;
        }

        .btn-style702::after {
            width: 0;
            left: 50%;
            border-top: 1px solid transparent;
            border-bottom: 1px solid transparent;
            transform: translate(-50%, 0);
            z-index: 1;
        }

        .btn-style702:hover,
        .btn-style702.active {
            color: #716eef;
        }

        .btn-style702:hover::before,
        .btn-style702.active::before {
            transform: scale(0, 1);
        }

        .btn-style702:hover::after,
        .btn-style702.active::after {
            width: 100%;
            border-color: #716eef;
            transition-delay: 0.2s;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function showInfo(infoId, btn) {
            // Ẩn tất cả các section thông tin
            document.getElementById('tuyen_dung').classList.remove('active');
            document.getElementById('tim_viec').classList.remove('active');

            // Hiển thị section tương ứng
            setTimeout(function() {
                document.getElementById(infoId).classList.add('active');
            }, 300); // Độ trễ để hiệu ứng mượt hơn

            // Loại bỏ class 'active' khỏi tất cả các nút
            var buttons = document.querySelectorAll('.btn-custom');
            buttons.forEach(function(button) {
                button.classList.remove('active');
            });

            // Thêm class 'active' cho nút hiện tại
            btn.classList.add('active');
        }
    </script>
@endpush

@section('content')
    @include('pages.components.button-register', [
        'buttonPosition' => 'left:15px',
        'buttonTitle' => 'Tuyển dụng',
        'buttonLink' => route('recruitment.registration'),
    ])
    @include('pages.components.button-register', [
        'buttonTitle' => 'Tìm Việc ngay',
        'buttonLink' => route('job.application'),
    ])

    <div class="container text-center mt-5rem">

        <div class="d-flex justify-content-center">

            <button class=" btn-custom click-btn btn-style702 active" id="btn-tuyen-dung" onclick="showInfo('tuyen_dung', this)">Tuyển
                dụng</button>
            <button class=" btn-custom click-btn btn-style702" id="btn-tim-viec" onclick="showInfo('tim_viec', this)">Tìm
                việc</button>
        </div>

        <div id="tuyen_dung" class="info-section active mt-4">
            <h3 class="text-center">Danh Sách Tuyển Dụng</h3>
            <div class="text-start">
                <!-- Vị trí công việc 1 -->
                <div class="job-listing">
                    <div class="d-flex mb-2">
                        <img src="{{ asset('images/sk.png') }}" alt="" class="" style="width: 100px ;height: 100px;    object-fit: scale-down;">
                        <h5 class="ms-2">Công ty Công nghệ</h5>
                    </div>
                    <h5>Lập trình viên chuyên nghiệp</h5>
                    <p><strong>Mô tả công việc:</strong> Phát triển và bảo trì phần mềm cho các dự án lớn.</p>
                    <p><strong>Yêu cầu:</strong> Có kinh nghiệm lập trình PHP, Laravel. Ưu tiên ứng viên có kinh nghiệm với
                        Docker.</p>
                    <p><strong>Lương:</strong> 20-30 triệu VND/tháng</p>
                    <p><strong>Địa điểm làm việc:</strong> Hà Nội</p>
                </div>

                <!-- Vị trí công việc 2 -->
                <div class="job-listing">
                    <h5>Nhân viên kinh doanh</h5>
                    <p><strong>Mô tả công việc:</strong> Tìm kiếm khách hàng và xây dựng mối quan hệ với đối tác doanh
                        nghiệp.</p>
                    <p><strong>Yêu cầu:</strong> Có kỹ năng giao tiếp tốt, kinh nghiệm làm việc trong lĩnh vực bán hàng.</p>
                    <p><strong>Lương:</strong> 15-25 triệu VND/tháng</p>
                    <p><strong>Địa điểm làm việc:</strong> TP. Hồ Chí Minh</p>
                </div>

                <!-- Vị trí công việc 3 -->
                <div class="job-listing">
                    <div class="d-flex mb-2">
                        <img src="{{ asset('images/logo-shop.png') }}" alt="" class="" style="width: 100px ;height: 100px;    object-fit: scale-down;">
                        <h5 class="ms-2">Công ty Công nghệ</h5>
                    </div>
                    <h5>Nhân viên IT Helpdesk</h5>
                    <p><strong>Mô tả công việc:</strong> Hỗ trợ kỹ thuật và xử lý các sự cố máy tính cho nội bộ công ty.</p>
                    <p><strong>Yêu cầu:</strong> Có kiến thức về mạng máy tính, hệ điều hành Windows/Linux.</p>
                    <p><strong>Lương:</strong> 10-15 triệu VND/tháng</p>
                    <p><strong>Địa điểm làm việc:</strong> Đà Nẵng</p>
                </div>
            </div>
        </div>

        <!-- Danh sách tìm việc -->
        <div id="tim_viec" class="info-section mt-4">
            <h3 class="text-center">Danh Sách Tìm Việc</h3>
            <div class="text-start">
                <!-- Ứng viên 1 -->
                <div class="row g-3">

                    <div class="applicant-listing col-12 col-md-6">
                        <h5>Họ và tên: Nguyễn Hoàn Tân</h5>
                        <div class="d-flex">
                            <p class="me-3"><strong>Năm sinh:</strong> 1990</p>
                            <p><strong>Giới tính:</strong> Nam</p>
                        </div>
                        <p><strong>Điện thoại:</strong> 0123456789</p>
                        <p><strong>Email:</strong> nguyenb@example.com</p>
                        <p><strong>Thông tin giới thiệu:</strong> Tôi là kỹ sư phần mềm có 5 năm kinh nghiệm trong lĩnh vực phát triển web.</p>
                        <p><strong>CV:</strong> <a href="#">Tải về</a>
                        </p>
                    </div>
    
                    <!-- Ứng viên 2 -->
                    <div class="applicant-listing col-12 col-md-6">
                        <h5>Họ và tên: Trần Thị Minh Thi</h5>
                        <div class="d-flex">
                            <p class="me-3"><strong>Năm sinh:</strong> 1995</p>
                            <p><strong>Giới tính:</strong> Nữ</p>
                        </div>
                        <p><strong>Điện thoại:</strong> 0987654321</p>
                        <p><strong>Email:</strong> tranc@example.com</p>
                        <p><strong>Thông tin giới thiệu:</strong> Tôi là kế toán viên với 3 năm kinh nghiệm tại các công ty vừa và nhỏ.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
