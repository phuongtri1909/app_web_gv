@extends('admin.layouts.app')

@push('styles-admin')
@endpush
@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('admission_consultation') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    @include('admin.pages.notification.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('id') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('age') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('full_name') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('address') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('phone') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('email') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('content') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('date') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('status') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admissions as $admission)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $admission->id }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $admission->age }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $admission->full_name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $admission->address }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $admission->phone }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $admission->email }}</p>
                                    </td>
                                    <td class="text-center" style="white-space: normal;width:250px">
                                        <p class="text-xs font-weight-bold mb-0">{{ $admission->content }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $admission->created_at }}</p>
                                    </td>

                                    <td class="text-center">
                                        @if ($admission->status === 'pending')
                                            <span class="badge badge-sm bg-gradient-warning">{{ __('pending') }}</span>
                                        @elseif ($admission->status === 'approved')
                                            <span class="badge badge-sm bg-gradient-success">{{ __('approved') }}</span>
                                        @elseif ($admission->status === 'rejected')
                                            <span class="badge badge-sm bg-gradient-danger">{{ __('rejected') }}</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        @if ($admission->status === 'pending')
                                            <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#actionModal" data-action="approve" data-item-id="{{ $admission->id }}">
                                                {{ __('approve') }}
                                            </button>
                                            <br>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#actionModal" data-action="reject" data-item-id="{{ $admission->id }}">
                                                {{ __('reject') }}
                                            </button>
                                        @endif
                                    </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actionModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="actionModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cancel') }}</button>
                    <button type="button" class="btn btn-primary" id="confirmAction"></button>
                </div>
            </div>
        </div>
    </div>
    
  
    <form id="actionForm" method="post" style="display: none;">
        @csrf
        <input type="hidden" name="item_id" id="formItemId">
    </form>
@endsection
@push('scripts-admin')
<script>
    $(document).ready(function () {
        $('#actionModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var action = button.data('action'); 
            var itemId = button.data('item-id');
            var modal = $(this);

            if (action === 'approve') {
                modal.find('.modal-title').text('{{ __('confirm_approve') }}');
                modal.find('.modal-body').text('{{ __('are_you_sure_approve') }}');
                modal.find('#confirmAction').text('{{ __('approve') }}').removeClass('btn-danger').addClass('btn-success');
                $('#actionForm').attr('action', '/admin/admissions/approve/' + itemId);
            } else if (action === 'reject') {
                modal.find('.modal-title').text('{{ __('confirm_reject') }}');
                modal.find('.modal-body').text('{{ __('are_you_sure_reject') }}');
                modal.find('#confirmAction').text('{{ __('reject') }}').removeClass('btn-success').addClass('btn-danger');
                $('#actionForm').attr('action', '/admin/admissions/reject/' + itemId);
            }

            $('#formItemId').val(itemId);
        });

        $('#confirmAction').on('click', function () {
            $('#actionForm').submit();
        });
    });
</script>
@endpush
