@php
    $slug = request()->segment(4);
@endphp
@foreach ($businessHouseholds as $index => $item)
    <tr>
        <td>{{ ($businessHouseholds->currentPage() - 1) * $businessHouseholds->perPage() + $loop->iteration }}</td>
        @if ($slug == 'cho-an-nhon')
            <td>
                <p class="w-max-content">{{ $item->business_owner_full_name }}</p>
            </td>
            <td>
                <p class="w-max-content">{{ $item->business_field }}</p>
            </td>
            <td>
                <p class="w-max-content">{{ $item->stalls }}</p>
            </td>
        @else
            <td>
                <p class="w-max-content">{{ $item->license_number }}</p>
            </td>
            <td>
                <p class="w-max-content">{{ $item->business_owner_full_name }}</p>
            </td>
            <td>
                <p class="w-max-content">{{ $item->signboard }}</p>
            </td>
            <td>
                <p class="w-max-content">{{ $item->address }}</p>
            </td>
            <td class="text-center">
                <button class="btn bg-app-gv rounded-pill text-white btn-sm w-max-content view-detail" data-id="{{ $item->id }}">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </td>
        @endif
    </tr>
@endforeach

<!-- Modal chi tiết -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Chi tiết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <!-- Nội dung chi tiết sẽ được tải ở đây -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.view-detail').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '/client/p17/business-household/' + id,
                    type: 'GET',
                    success: function(data) {
                        // Hiển thị dữ liệu chi tiết, ví dụ bằng modal
                        $('#detailModal .modal-body').html(data);
                        $('#detailModal').modal('show');
                    },
                    error: function(err) {
                        console.log(err);

                    }
                });
            });
        });
    </script>
@endpush
