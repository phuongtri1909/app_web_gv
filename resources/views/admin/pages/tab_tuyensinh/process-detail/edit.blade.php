@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('edit_detail_process') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">
                
                @include('admin.pages.notification.success-error')

                <form action="{{ route('admission-process-detail.update',$processDetail->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        @foreach ($languages as $language)
                            <div class="form-group mb-3 col-md-6">
                                <label for="{{ 'title_'.$language->locale }}">{{ __('title') }}:
                                    {{ $language->name }}</label>
                                <input type="text" name="{{ 'title_'.$language->locale }}"
                                    id="{{ 'title_'.$language->locale }}"
                                    class="form-control @error('title_'.$language->locale) is-invalid @enderror"
                                    value="{{ old('title_'.$language->locale, $processDetail->getTranslation('title', $language->locale)) }}" required>
                                @error('title_'.$language->locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach

                        @foreach ($languages as $language)
                            <div class="form-group mb-3 col-12">
                                <label for="content_{{ $language->locale }}">{{ __('description') }} {{ $language->name }}</label>
                                <textarea name="content_{{ $language->locale }}" id="content_{{ $language->locale }}"
                                    class="form-control @error('content_{{ $language->locale }}') is-invalid @enderror">{!! old('content_'.$language->locale,$processDetail->getTranslation('content', $language->locale)) !!}</textarea>
                                @error('content_{{ $language->locale }}')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach

                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                        <a href="{{ route('admission-process.show',$process->id) }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')
    <script src="https://cdn.tiny.cloud/1/zjp51ea7s0xnyrx2gv55bqdfz99zaqaugg0w5fbt5uxu5q2q/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        @foreach($languages as $language)
            tinymce.init({
                selector: '#content_{{ $language->locale }}',  
                height: 300,
                plugins: "  advlist  anchor  autolink autoresize autosave  charmap  code codesample directionality  emoticons  fullscreen help image importcss  insertdatetime link linkchecker lists media   nonbreaking pagebreak   preview quickbars save searchreplace table  tinydrive   visualblocks visualchars wordcount",
                toolbar: 'undo redo | formatselect | bold italic backcolor | \
                      alignleft aligncenter alignright alignjustify | \
                      bullist numlist outdent indent | removeformat | table pargraph',
                toolbar_mode: 'floating',
                formats: {
                    // Định nghĩa kiểu danh sách
                    lower_alpha_list: { block: 'ol', classes: 'lower-alpha' },
                    upper_roman_list: { block: 'ol', classes: 'upper-roman' }
                },
                style_formats: [
                    { title: 'Lower Alpha', format: 'lower_alpha_list' },
                    { title: 'Upper Roman', format: 'upper_roman_list' }
                ],
                extended_valid_elements: 'li[class|style]',
                content_css: '{{ asset('css/tinymce.css') }}',
                });
        @endforeach
    </script>
@endpush