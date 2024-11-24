@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square {
            object-fit: scale-down;
        }

        .overflow-y-hidden {
            overflow-y: hidden;
        }

        .info-group label {
            color: #8392AB;
            margin-bottom: 4px;
        }
        .info-group p {
            color: #344767;
            font-weight: 500;
        }
        .form-control:focus {
            box-shadow: none;
        }
    </style>
@endpush

@section('content-auth')
@include('pages.components.toast')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Danh sách tài khoản</h5>
                    </div>
                    <a href="{{ route('users.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                        <i class="fa-solid fa-plus"></i> Thêm tài khoản
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @include('admin.pages.notification.success-error')

                <div class="table-responsive p-0 overflow-y-hidden">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('STT') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Avatar</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tài khoản</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tên</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Doanh nghiệp</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">role</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ __('Không có kết quả nào.') }}</p>
                                    </td>
                                </tr>
                            @else
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <img src="{{ $user->avatar ? asset($user->avatar) : asset('images/avatar/avatar_default.jpg') }}"
                                                alt="avatar" class="img-square rounded-circle" width="50" height="50">
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->username ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->full_name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->email ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $user->businessMember->business_name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-{{ $user->role == 'admin' ? 'success' : ($user->role == 'business' ? 'danger' : 'warning') }}" >
                                                {{ $user->role == 'admin' ? 'Admin' : ($user->role == 'business' ? 'Business' : 'User') }}
                                            </span>
                                        </td>
                                        
                                        <td>
                                            <span id="status-badge-{{ $user->id }}"
                                                class="badge badge-sm bg-{{ $user->status == 'active' ? 'success' : ($user->status == 'inactive' ? 'danger' : 'warning') }}"  data-status="{{ $user->status }}">
                                                {{ $user->status == 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm p-0 border-0 mb-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    title="Thay đổi trạng thái">
                                                    <i class="fas fa-retweet"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item change-status" href="#" data-status="active" data-user-id="{{ $user->id }}">
                                                            <i class="fas fa-check-circle text-success me-2"></i>Active
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item change-status" href="#" data-status="inactive" data-user-id="{{ $user->id }}">
                                                            <i class="fas fa-times-circle text-danger me-2"></i>Inactive
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm p-0 border-0 mb-0" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @include('admin.pages.components.delete-form', [
                                                'id' => $user->id,
                                                'route' => route('users.destroy', $user->id),
                                                'message' => 'Bạn có chắc chắn muốn xóa tài khoản này không?',
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <x-pagination :paginator="$users" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts-admin')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('.change-status').on('click', function(e) {
                e.preventDefault();
    
                var userId = $(this).data('user-id');
                var status = $(this).data('status');
    
                $.ajax({
                    url: '{{ route('user.changeStatus') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        status: status
                    },
                    success: function(response) {
                        if (response.error) {
                            showToast(response.error, 'error');
                        } else {
                            showToast(response.success, 'success');

                            var badge = $('#status-badge-' + userId);

                            if (status === 'active') {
                                badge.removeClass('bg-danger').addClass('bg-success').text('Active');
                            } else {
                                badge.removeClass('bg-success').addClass('bg-danger').text('Inactive');
                            }
                        }
                    }
                });
            });
        });
    </script>
   
@endpush