@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square {
            width: 200px;
            height: 100px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('Danh sách mẫu email') }}</h5>
                        </div>
                        <a href="{{ route('email_templates.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2"
                            type="button"><i class="fa-solid fa-plus"></i> {{ __('Tạo mẫu email') }}</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    @include('admin.pages.notification.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('STT') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Tên mẫu') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Hành động') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templates as $key => $template)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $template->name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('email_templates.edit', $template->id) }}" class="mx-3"
                                                title="{{ __('Chỉnh sửa') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <a href="#" class="mx-3 preview-template"
                                                data-content="{{ $template->content }}" data-name="{{ $template->name }}"
                                                title="{{ __('Xem trước') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $template->id,
                                                'route' => route('email_templates.destroy', $template->id),
                                                'message' => __('Bạn có chắc chắn muốn xóa?'),
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $templates->links() }} --}}
                    </div>
                    <!-- Modal xem trước mẫu email -->
                    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="previewModalLabel">Xem trước mẫu email</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="templateContent" style="white-space: pre-line;"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        $(document).ready(function() {
            $('.preview-template').on('click', function(e) {
                e.preventDefault();
                var templateContent = $(this).data('content');
                $('#templateContent').html(templateContent);
                $('#previewModal').modal('show');
            });
        });
    </script>
@endpush
