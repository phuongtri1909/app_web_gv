//update status

function updateStatus(model, id, status) {
    let badge = $('#status-badge-' + id);
    let currentStatus = badge.data('status');

    if (currentStatus === 'approved' || currentStatus === 'rejected') {
        new Noty({
            type: 'error',
            text: 'Không thể thay đổi trạng thái khi đã duyệt hoặc từ chối.',
            timeout: 1500
        }).show();
        return;
    }

    $.ajax({
        url: '/admin/update-status',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            model: model,
            id: id,
            status: status
        },
        success: function(response) {
            if (response.success) {
                badge.removeClass('bg-success bg-danger bg-warning').data('status',
                    status);

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
        error: function(xhr) {
            new Noty({
                type: 'error',
                text: 'Cập nhật trạng thái thất bại: ' + (xhr.responseJSON.message ||
                    'Không rõ lý do'),
                timeout: 1500

            }).show();
        }
    });
}
