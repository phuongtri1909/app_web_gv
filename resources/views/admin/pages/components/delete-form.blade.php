<form id="formDelete{{ $id }}" method="post" action="{{ $route }}">
    @csrf
    @method('DELETE')
    <span title="{{ __('delete') }}" type="button" class=" btn_delete">
        <i class="fa-solid fa-trash"></i>
    </span>
</form>

<div class="modal fade modal-center" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ __('accept_delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ isset($message) ? $message : __('delete_message') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary text-dark" data-bs-dismiss="modal">{{ __('cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">{{ __('delete') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts-admin')
    <script>
        $('.btn_delete').click(function() {
            $('#deleteModal').modal('show');

            var formId = $(this).closest('form').attr('id');

            $('#confirmDelete').click(function() {
                $('#' + formId).submit();
            });
        });
    </script>
@endpush
