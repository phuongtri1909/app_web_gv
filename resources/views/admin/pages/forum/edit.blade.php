@extends('admin.layouts.app')

@section('content-auth')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('edit_forum') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('forums.update', $forum->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.pages.notification.success-error')
                    @method('PUT')
                    <div class="row">
                        @foreach ($languages as $language)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{ 'title-' . $language->locale }}">{{ __('title') }}:
                                        {{ $language->name }}</label>
                                    <input type="text" name="{{ 'title-' . $language->locale }}" class="form-control"
                                        id="{{ 'title-' . $language->locale }}"
                                        value="{{ old('title-' . $language->locale, $translatedTitlesAlt[$language->locale]) }}"
                                        required>
                                    @error('title-' . $language->locale)
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <label for="image">{{ __('image') }}</label>
                            <input type="file" name="image[]" multiple
                                class="form-control @error('image') is-invalid @enderror" id="image">

                                @if ($forum->key_page === 'key_forum_cp3' && $forum->image)
                                    @php
                                        $currentImages = json_decode($forum->image, true);
                                    @endphp
                                    @if (is_array($currentImages))
                                        <div style="margin-top: 10px;">
                                            <strong>{{ __('current_media') }}:</strong>
                                            <div>
                                                @foreach ($currentImages as $index => $img)
                                                    <div style="display: inline-block; position: relative;">
                                                        <img src="{{ asset($img) }}" alt="{{ __('current_media') }}" style="max-width: 100px; margin: 5px;">
                                                        <input type="checkbox" name="delete_images[]" value="{{ $index }}"> {{ __('delete') }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if ($forum->image)
                                        <img src="{{ asset($forum->image) }}" alt="{{ __('current_media') }}"
                                            style="max-width: 100px; margin-top: 10px;">
                                    @endif
                                @endif
                            @error('image.*')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="key_page">{{ __('key_page_fr') }}</label>
                            <input type="text" name="key_page"
                                class="form-control @error('key_page') is-invalid @enderror" id="key_page"
                                value="{{ old('key_page', $forum->key_page) }}">
                            @error('key_page')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="active">{{ __('active') }}</label>
                            <select name="active" class="form-control @error('active') is-invalid @enderror"
                                id="active">
                                <option value="yes" {{ old('active', $forum->active) == 'yes' ? 'selected' : '' }}>
                                    {{ __('yes') }}</option>
                                <option value="no" {{ old('active', $forum->active) == 'no' ? 'selected' : '' }}>
                                    {{ __('no') }}</option>
                            </select>
                            @error('active')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts-admin')
<script src="https://cdn.tiny.cloud/1/94rfxe6iw4a63rhexl9m1wnjy9xkor08bhxft539qnuxepbv/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    @foreach($languages as $language)
        tinymce.init({
            selector: '#title-{{ $language->locale }}',
            height: 300,
            plugins: "  advlist  anchor  autolink autoresize autosave  charmap  code codesample directionality  emoticons  fullscreen help image importcss  insertdatetime link linkchecker lists media    nonbreaking pagebreak   preview quickbars save searchreplace table  template tinydrive   visualblocks visualchars wordcount",
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | table',
            toolbar_mode: 'floating',
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });
    @endforeach
</script>
@endpush
