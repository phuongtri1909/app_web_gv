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

        .job-listing,
        .applicant-listing {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .job-listing h5,
        .applicant-listing h5 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .job-listing p,
        .applicant-listing p {
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
            background: linear-gradient(45deg, rgb(230, 230, 230), rgb(207, 207, 207));
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
            color: transparent;
            background: linear-gradient(45deg, orange, yellow);
            -webkit-background-clip: text;
            background-clip: text;
        }

        .btn-style702:hover::before,
        .btn-style702.active::before {
            transform: scale(0, 1);
        }

        .btn-style702:hover::after,
        .btn-style702.active::after {
            width: 100%;
            border-color: transparent;
            background: linear-gradient(45deg, rgba(255, 182, 108, 0.3), rgba(255, 255, 0, 0.3));
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
        'buttonTitle' => 'Tìm Việc',
        'buttonLink' => route('job.application'),
    ])

    <div class="container text-center mt-5rem">

        <div class="d-flex justify-content-center">

            <button class=" btn-custom click-btn btn-style702 active text-dark fw-bold" id="btn-tuyen-dung"
                onclick="showInfo('tuyen_dung', this)">Tuyển
                dụng</button>
            <button class=" btn-custom click-btn btn-style702 text-dark fw-bold" id="btn-tim-viec"
                onclick="showInfo('tim_viec', this)">Tìm
                việc</button>
        </div>

        <div id="tuyen_dung" class="info-section active mt-4">
            <h3 class="text-center">Danh Sách Tuyển Dụng</h3>
            <div class="text-start" id="recruitment-list">
                
            </div>
        </div>

       
        <div id="tim_viec" class="info-section mt-4">
            <h3 class="text-center">Danh Sách Tìm Việc</h3>
            <div class="text-start" id="job-list">
              
            </div>
        </div>
    </div>


    <div class="modal fade" id="recruitmentDetailModal" tabindex="-1" aria-labelledby="recruitmentDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card shadow-lg">
                    <div class="card-header bg-app-gv p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="text-white mb-0">
                                <i class="fas fa-building me-2"></i>
                                {{ __('Thông tin chi tiết tuyển dụng') }}
                            </h5>
                            <button type="button" class="btn btn-link text-white" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-4 text-center">
                                <div class="avatar-preview mb-3">
                                    <img id="modal-avatar" src="" class="rounded-circle img-fluid shadow"
                                        style="width: 150px; height: 150px; object-fit: scale-down;" alt="Business Avatar">
                                </div>
                                <h6 id="modal-business-name" class="fw-bold text-primary"></h6>
                                <p class="text-muted small">MST: <span id="modal-business-code"></span></p>

                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <h6 id="modal-recruitment-title" class="fw-bold text-primary"></h6>
                                    <p id="modal-recruitment-content" class="text-sm mb-2"></p>
                                </div>
                                <div id="modal-recruitment-images">
                                    <a href="" data-fancybox="gallery">
                                        <img src="" alt="Recruitment Image"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script>
       $(document).on('click', '.view-recruitment', function() {
            var recruitmentId = $(this).data('id');
            $.ajax({
                    url: '/recruitment/' + recruitmentId,
                    type: 'GET',
                    success: function(response) {
                        if (!response) {
                            showToast('Không tìm thấy dữ liệu', 'error');
                            return;
                        }

                        $('#modal-avatar').attr('src', response.avt_businesses || '/images/default-avatar.png');
                        $('#modal-business-name').text(response.business_name || '-');
                        $('#modal-business-code').text(response.business_code || '-');

                        $('#modal-recruitment-title').text(response.recruitment_title || '-');
                        $('#modal-recruitment-content').html(response.recruitment_content ||
                            '-');

                        $('#modal-recruitment-images').empty();
                        if (response.recruitment_images && response.recruitment_images.length > 0) {
                            response.recruitment_images.forEach(function(image) {
                                $('#modal-recruitment-images').append(`
                                    <a href="${image}" data-fancybox="gallery">
                                        <img src="${image}" alt="Recruitment Image" style="width: 50px; height: 50px; object-fit: cover;">
                                    </a>
                                `);
                            });
                        }

                        const statusBadgeClass = {
                            'approved': 'bg-success',
                            'rejected': 'bg-danger',
                            'pending': 'bg-warning'
                        } [response.status] || 'bg-secondary';

                        const statusText = {
                            'approved': 'Đã duyệt',
                            'rejected': 'Đã từ chối',
                            'pending': 'Đang chờ'
                        } [response.status] || '-';

                        $('#modal-status')
                            .removeClass('bg-success bg-danger bg-warning bg-secondary')
                            .addClass(statusBadgeClass)
                            .text(statusText);

                        $('#recruitmentDetailModal').modal('show');
                    },
                    error: function(error) {
                        console.log(error);
                    
                        showToast(error.responseJSON.message, 'error');
                    }
                });
            });
    </script>
    <script>
        var pageRecruitment = 1;  
        var pageJob = 1;  
    
        function loadRecruitments(page = 1) {
            $.ajax({
                url: '{{ route("job-connector") }}?page=' + page,  
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.recruitments.data.length > 0) {
                        var recruitmentList = '';
                        $.each(response.recruitments.data, function(index, item) {
                            if ($('#recruitment-list').find('[data-id="' + item.id + '"]').length == 0) {
                                var businessName = item.business_member ? item.business_member.business_name : 'Tên doanh nghiệp không có';
                                var businessAvatar = item.business_member && item.business_member.business ? item.business_member.business.avt_businesses : '/images/business/business_default.webp';
                                recruitmentList += `
                                    <div class="job-listing" data-id="${item.id}">
                                        <div class="d-flex mb-2">
                                            <img src="{{ asset('${businessAvatar}') }}" alt="" style="width: 100px; height: 100px; object-fit: scale-down;">
                                            <h5 class="ms-2">${businessName}</h5>
                                        </div>
                                        <h5>${item.recruitment_title}</h5>
                                        <p><strong>Mô tả công việc:</strong> ${item.recruitment_content.length > 800 ? item.recruitment_content.substr(0, 800) + '...' : item.recruitment_content}</p>

                                        <a href="javascript:void(0);" class="view-recruitment" data-id="${item.id}">Xem thêm</a>
                                    </div>`;
                            }
                        });
                        $('#recruitment-list').append(recruitmentList);  
                        if (page < response.recruitments.last_page) {
                            pageRecruitment = page + 1;  
                        } else {
                            pageRecruitment = null;     
                        }
                    }
                }
            });
        }
    
        function loadJobApplications(page = 1) {
            $.ajax({
                url: '{{ route("job-connector") }}?page=' + page, 
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.jobApplications.data.length > 0) {
                        var jobList = '';
                        $.each(response.jobApplications.data, function(index, item) {
                            if ($('#job-list').find('[data-id="' + item.id + '"]').length == 0) {
                                jobList += `
                                    <div class="applicant-listing col-12 col-md-6" data-id="${item.id}">
                                        <h5>Họ và tên: ${item.full_name}</h5>
                                        <div class="d-flex">
                                            <p class="me-3"><strong>Năm sinh:</strong> ${item.birth_year}</p>
                                            <p><strong>Giới tính:</strong> ${item.gender == 'male' ? 'Nam' : item.gender == 'female' ? 'Nữ' : 'Khác'}</p>
                                        </div>
                                        <p><strong>Điện thoại:</strong> ${item.phone}</p>
                                        <p><strong>Thông tin giới thiệu:</strong> ${item.job_registration}</p>
                                        <p><strong>CV:</strong> <a href="${item.cv}">Tải về</a></p>
                                    </div>`;
                            }
                        });
                        $('#job-list').append(jobList); 

                        if (page < response.jobApplications.last_page) {
                            pageJob = page + 1; 
                        } else {
                            pageJob = null; 
                        }
                    }
                }
            });
        }
    
       
        $(window).scroll(function() {
           
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                if (pageRecruitment) {
                    loadRecruitments(pageRecruitment);  
                }
                if (pageJob) {
                    loadJobApplications(pageJob);
                }
            }
        });
        loadRecruitments(); 
        loadJobApplications();  
    </script>
@endpush
