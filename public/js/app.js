//update status

function updateStatus (model, id, status) {
    let badge = $('#status-badge-' + id)
    let currentStatus = badge.data('status')

    if (model !== 'BusinessMember' && (currentStatus === 'approved' || currentStatus === 'rejected')) {
        new Noty({
            type: 'error',
            text: 'Không thể thay đổi trạng thái khi đã duyệt hoặc từ chối.',
            timeout: 1500
        }).show()
        return
    }
    Swal.fire({
        title: 'Xác nhận cập nhật',
        text: `Bạn có chắc chắn muốn thay đổi trạng thái không?`,
        icon: 'warning',
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Cập nhật',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/update-status',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    model: model,
                    id: id,
                    status: status
                },
                success: function (response) {
                    if (response.success) {
                        badge
                            .removeClass('bg-success bg-danger bg-warning')
                            .data('status', status);

                        if (status === 'approved') {
                            badge.addClass('bg-success').text('Đã duyệt');
                        } else if (status === 'rejected') {
                            badge.addClass('bg-danger').text('Đã từ chối');
                        } else {
                            badge.addClass('bg-warning').text('Đang chờ');
                        }

                        new Noty({
                            type: 'success',
                            text: response.message,
                            timeout: 1500
                        }).show();
                    }
                },
                error: function (xhr) {
                    new Noty({
                        type: 'error',
                        text:
                            'Cập nhật trạng thái thất bại: ' +
                            (xhr.responseJSON.message || 'Không rõ lý do'),
                        timeout: 1500
                    }).show();
                }
            });
        }
    });
}

function updateStatus1(model, id, status) {
    const badge = $('#status-badge-' + id);
    const currentStatus = badge.data('status');

    if (currentStatus === 'completed') {
        new Noty({
            type: 'error',
            text: 'Không thể thay đổi trạng thái khi đã hoàn thành.',
            timeout: 1500
        }).show();
        return;
    }

    if (currentStatus === 'pending' && status === 'completed') {
        new Noty({
            type: 'error',
            text: 'Không thể chuyển trực tiếp từ Đang chờ sang Hoàn thành. Vui lòng chuyển qua Đang xử lý trước.',
            timeout: 1500
        }).show();
        return;
    }
    if (currentStatus === 'in_progress' && status === 'pending') {
        new Noty({
            type: 'error',
            text: 'Không thể chuyển từ Đang xử lý về Đang chờ.',
            timeout: 1500
        }).show();
        return;
    }

    Swal.fire({
        title: 'Xác nhận cập nhật',
        text: `Bạn có chắc chắn muốn thay đổi trạng thái không?`,
        icon: 'warning',
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Cập nhật',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/update-status-1',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    model: model,
                    id: id,
                    status: status
                },
                success: function (response) {
                    if (response.success) {
                        const { status, statusLabel, statusClass } = response;
                        badge
                            .removeClass('bg-success bg-info bg-warning')
                            .addClass('bg-' + statusClass)
                            .text(statusLabel)
                            .data('status', status);

                        new Noty({
                            type: 'success',
                            text: response.message,
                            timeout: 1500
                        }).show();
                    } else {
                        new Noty({
                            type: 'error',
                            text: response.message,
                            timeout: 1500
                        }).show();
                    }
                },
                error: function (xhr) {
                    const errorMessage =
                        xhr.responseJSON?.message || 'Cập nhật trạng thái thất bại: Không rõ lý do';

                    new Noty({
                        type: 'error',
                        text: errorMessage,
                        timeout: 1500
                    }).show();
                }
            });
        }
    });
}

function updateStatus2(model, id, status) {
    const badge = $('#status-badge-' + id);
    const currentStatus = badge.data('status');

    // if (currentStatus === 'active') {
    //     new Noty({
    //         type: 'error',
    //         text: 'Không thể thay đổi trạng thái khi đã chấp nhận.',
    //         timeout: 1500
    //     }).show();
    //     return;
    // }

    // if (currentStatus === 'active' && status === 'inactive') {
    //     new Noty({
    //         type: 'error',
    //         text: 'Không thể thay đổi trạng thái khi đã chấp nhận hoặc từ chối.',
    //         timeout: 1500
    //     }).show();
    //     return;
    // }

    Swal.fire({
        title: 'Xác nhận cập nhật',
        text: `Bạn có chắc chắn muốn thay đổi trạng thái không?`,
        icon: 'warning',
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Cập nhật',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/update-status-2',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    model: model,
                    id: id,
                    status: status
                },
                success: function (response) {
                    if (response.success) {
                        const { status, statusLabel, statusClass } = response;
                        badge
                            .removeClass('bg-success bg-danger bg-warning')
                            .addClass('bg-' + statusClass)
                            .text(statusLabel)
                            .data('status', status);

                        new Noty({
                            type: 'success',
                            text: response.message,
                            timeout: 1500
                        }).show();
                    } else {
                        new Noty({
                            type: 'error',
                            text: response.message,
                            timeout: 1500
                        }).show();
                    }
                },
                error: function (xhr) {
                    const errorMessage =
                        xhr.responseJSON?.message || 'Cập nhật trạng thái thất bại: Không rõ lý do';
                        console.log(errorMessage); 
                    new Noty({
                        type: 'error',
                        text: errorMessage,
                        timeout: 1500
                    }).show();
                }
            });
        }
    });
}

// thong bao loi form ngoai client

const form = document.querySelector('form')
if (form) {
    form.addEventListener('submit', function (e) {
        let isValid = true

        const errorMessages = {
            recaptcha: 'Vui lòng hoàn thành CAPTCHA để tiếp tục.',
            supportNeed: 'Vui lòng chọn một nhu cầu hỗ trợ.',
            fileInput: 'Vui lòng chọn file để tải lên.',
            fileInput1: 'Vui lòng chọn ảnh đại diện doanh nghiệp để tải lên.',
            representativeName: 'Vui lòng nhập họ tên chủ doanh nghiệp.',
            birthYear: 'Vui lòng nhập năm sinh.',
            phoneNumber: 'Vui lòng nhập số điện thoại.',
            address: 'Vui lòng nhập địa chỉ cư trú.',
            businessAddress: 'Vui lòng nhập địa chỉ kinh doanh.',
            businessName: 'Vui lòng nhập tên doanh nghiệp.',
            businessCode: 'Vui lòng nhập mã số thuế.',
            gender: 'Vui lòng chọn giới tính.',
            headOfficeAddress: 'Vui lòng nhập địa chỉ trụ sở chính.',
            recruitmentInfo:
                'Vui lòng nhập thông tin đăng ký tuyển dụng nhân sự.',
            fullName: 'Vui lòng nhập họ tên',
            introduction: 'Vui lòng nhập giới thiệu về bản thân',
            jobRegistration: 'Vui lòng nhập thông tin đăng ký tìm việc',
            interestRate: 'Vui lòng nhập lãi suất mong muốn',
            finance: 'Vui lòng nhập số tiền tài chính',
            mortgagePolicy: 'Vui lòng nhập chính sách vay thế chấp',
            unsecuredPolicy: 'Vui lòng nhập thông tin tín chấp',
            purpose: 'Vui lòng nhập mục đích vay',
            bankConnection: 'Vui lòng nhập ngân hàng kết nối',
            opinion: 'Vui lòng nhập ý kiến',
            attachedImages: 'Vui lòng chọn 1 ảnh để tải lên',
            residentialAddress: 'Vui lòng chọn địa chỉ cư trú',
            businessLicense: 'Vui lòng chọn 1 file để tải lên',
            license: 'Vui lòng tải giấy phép kinh doanh',
            description: 'Vui lòng nhập thông tin',
            placeName: 'Vui lòng nhập tên địa điểm'
        }

        document
            .querySelectorAll('.error-message')
            .forEach(el => (el.textContent = ''))
        document
            .querySelectorAll('.invalid-feedback')
            .forEach(el => (el.textContent = ''))

        const recaptchaResponse = grecaptcha.getResponse()
        const recaptchaError = document.getElementById('recaptcha-error')
        if (!recaptchaResponse && recaptchaError) {
            recaptchaError.textContent = errorMessages.recaptcha
            isValid = false
        }

        const fileInputs = {
            'file-uploads': errorMessages.fileInput,
            'file-upload': errorMessages.fileInput1
        }

        Object.entries(fileInputs).forEach(([id, message]) => {
            const input = document.getElementById(id)
            const errorDisplay = document.getElementById(
                `error-message${id === 'file-upload' ? '1' : ''}`
            )

            if (input && input.files.length === 0) {
                if (errorDisplay) errorDisplay.textContent = message
                isValid = false
            } else if (errorDisplay) {
                errorDisplay.textContent = ''
            }
        })

        const requiredFields = [
            {
                id: 'representative_name',
                message: errorMessages.representativeName
            },
            { id: 'birth_year', message: errorMessages.birthYear },
            { id: 'phone', message: errorMessages.phoneNumber },
            { id: 'phone_number', message: errorMessages.phoneNumber },
            { id: 'address', message: errorMessages.address },
            { id: 'business_address', message: errorMessages.businessAddress },
            { id: 'businessName', message: errorMessages.businessName },
            { id: 'business_name', message: errorMessages.businessName },
            { id: 'businessCode', message: errorMessages.businessCode },
            { id: 'business_code', message: errorMessages.businessCode },
            {
                id: 'head_office_address',
                message: errorMessages.headOfficeAddress
            },
            { id: 'recruitment_info', message: errorMessages.recruitmentInfo },
            { id: 'full_name', message: errorMessages.fullName },
            { id: 'introduction', message: errorMessages.introduction },
            { id: 'job_registration', message: errorMessages.jobRegistration },
            { id: 'interest_rate', message: errorMessages.interestRate },
            { id: 'finance', message: errorMessages.finance },
            { id: 'mortgage_policy', message: errorMessages.mortgagePolicy },
            { id: 'unsecured_policy', message: errorMessages.unsecuredPolicy },
            { id: 'purpose', message: errorMessages.purpose },
            { id: 'bank_connection', message: errorMessages.bankConnection },
            { id: 'opinion', message: errorMessages.opinion },
            { id: 'attached_images', message: errorMessages.attachedImages },
            {
                id: 'residential_address',
                message: errorMessages.residentialAddress
            },
            { id: 'business_license', message: errorMessages.businessLicense },
            { id: 'logo', message: errorMessages.attachedImages },
            { id: 'license', message: errorMessages.license },
            { id: 'description', message: errorMessages.description },
            { id: 'place_name', message: errorMessages.placeName }
        ]

        requiredFields.forEach(field => {
            const input = document.getElementById(field.id)
            const errorDisplay = input ? input.nextElementSibling : null

            if (input && !input.value.trim()) {
                if (errorDisplay) errorDisplay.textContent = field.message
                isValid = false
            } else if (errorDisplay) {
                errorDisplay.textContent = ''
            }
        })

        const supportNeedInputs = document.querySelectorAll(
            'input[name="support_need"]'
        )
        const supportNeedSelected = [...supportNeedInputs].some(
            input => input.checked
        )
        const supportNeedError = document.querySelector('.support-need-error')

        if (!supportNeedSelected && supportNeedError) {
            supportNeedError.textContent = errorMessages.supportNeed
            isValid = false
        } else if (supportNeedError) {
            supportNeedError.textContent = ''
        }

        const genderInputs = document.querySelectorAll('input[name="gender"]')
        const genderSelected = [...genderInputs].some(input => input.checked)
        const genderError = document.querySelector('.gender-error')

        if (!genderSelected && genderError) {
            genderError.textContent = errorMessages.gender
            isValid = false
        } else if (genderError) {
            genderError.textContent = ''
        }

        if (!isValid) {
            e.preventDefault()
        }
    })
}

function showToast(message, status) {
    const toastElement = $('#liveToast');
    const toastBody = toastElement.find('.toast-body');

    // Cập nhật nội dung tin nhắn
    toastBody.text(message);

    // Xóa các lớp nền cũ
    toastElement.removeClass('bg-success bg-danger text-white');

    // Thêm lớp nền dựa trên trạng thái
    if (status === 'success') {
        toastElement.addClass('bg-success text-white');
    } else if (status === 'error') {
        toastElement.addClass('bg-danger text-white');
    }

    // Hiển thị toast
    const toast = new bootstrap.Toast(toastElement[0]);
    toast.show();
}


function validateImageInput(event) {
    const input = event.target;
    const files = input.files;
    const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
    const errorContainer = input.nextElementSibling;

    if (files.length > 0) {
        for (let i = 0; i < files.length; i++) {
            if (!validImageTypes.includes(files[i].type)) {
                if (errorContainer && errorContainer.classList.contains('invalid-feedback')) {
                    errorContainer.style.display = 'block';
                    errorContainer.textContent = 'Vui lòng chọn một tệp hình ảnh hợp lệ (jpeg, png, jpg, gif, webp).';
                } else {
                    showToast('Chỉ chấp nhận ảnh định dạng JPEG, PNG, JPG, GIF, WEBP.', 'error');
                }
                input.value = ''; // Clear the input
                return;
            }
        }
        if (errorContainer && errorContainer.classList.contains('invalid-feedback')) {
            errorContainer.style.display = 'none';
        }
    }
}

function validateDocumentInput(event) {
    const input = event.target;
    const files = input.files;
    const validDocumentTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
    const errorContainer = input.nextElementSibling;

    if (files.length > 0) {
        for (let i = 0; i < files.length; i++) {
            if (!validDocumentTypes.includes(files[i].type)) {
                if (errorContainer && errorContainer.classList.contains('invalid-feedback')) {
                    errorContainer.style.display = 'block';
                    errorContainer.textContent = 'Vui lòng chọn một tệp tài liệu hợp lệ (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX).';
                } else {
                    showToast('Vui lòng chọn một tệp tài liệu hợp lệ (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX).','error');
                }
                input.value = ''; // Clear the input
                return;
            }
        }
        if (errorContainer && errorContainer.classList.contains('invalid-feedback')) {
            errorContainer.style.display = 'none';
        }
    }
}
