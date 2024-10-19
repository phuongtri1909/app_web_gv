<div id="send-admission">
    @include('pages.notification.success-error')
    <p class="note text-center">*{{ __('contact_admission_consultation',['content' => $content]) }}:</p>
    <div class="table-contact">
        <form action="{{ route('send-admission') }}" method="post" id="form_send_admission">
            @csrf
            <table class="table table-custom table-bordered">
                <tbody>
                    <tr>
                        <th scope="row" class="bg-th">{{ __('age_group.age_of_child') }}</th>
                        <td class="p-3">
                            <span class="me-3">
                                <input value="1-2" type="radio" name="age" class="me-2" {{ old('age') == '1-2' ? 'checked' : '' }}>
                                <label class="fw-bold" for="age">{{ __('age_group.1_2') }}</label>
                            </span>
                            <span class="me-3">
                                <input value="2-3" type="radio" name="age" class="me-2" {{ old('age') == '2-3' ? 'checked' : '' }}>
                                <label class="fw-bold" for="age">{{ __('age_group.2_3') }}</label>
                            </span>
                            <span class="me-3">
                                <input value="3-4" type="radio" name="age" class="me-2" {{ old('age') == '3-4' ? 'checked' : '' }}>
                                <label class="fw-bold" for="age">{{ __('age_group.3_4') }}</label>
                            </span>
                            <span class="me-3">
                                <input value="4-5" type="radio" name="age" class="me-2" {{ old('age') == '4-5' ? 'checked' : '' }}>
                                <label class="fw-bold" for="age">{{ __('age_group.4_5') }}</label>
                            </span>
                            <span class="me-3">
                                <input value="5-6" type="radio" name="age" class="me-2" {{ old('age') == '5-6' ? 'checked' : '' }}>
                                <label class="fw-bold" for="age">{{ __('age_group.5_6') }}</label>
                            </span>
                            @if ($errors->has('age'))
                                <div class="text-danger">{{ $errors->first('age') }}</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-th">{{ __('form.full_name') }} <span class="cl-red">*</span></th>
                        <td class="p-3">
                            <input type="text" class="form-control" name="full_name" required value="{{ old('full_name') }}">
                            @if ($errors->has('full_name'))
                                <div class="text-danger">{{ $errors->first('full_name') }}</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-th">{{ __('form.address') }}</th>
                        <td class="p-3">
                            <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <div class="text-danger">{{ $errors->first('address') }}</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-th">{{ __('form.phone') }} <span class="cl-red">*</span></th>
                        <td class="p-3">
                            <input type="phone" class="form-control" name="phone" required value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                                <div class="text-danger">{{ $errors->first('phone') }}</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-th">{{ __('form.email') }} <span class="cl-red">*</span></th>
                        <td class="p-3">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-th">{{ __('form.content') }}</th>
                        <td class="p-3">
                            <textarea style="height: 130px;" type="text" class="form-control" name="content">{{ old('content') }}</textarea>
                            @if ($errors->has('content'))
                                <div class="text-danger">{{ $errors->first('content') }}</div>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            </div>
        
            <div class="text-center mt-3"> <button class="btn btn-md btn-send-addmission">{{ __('send') }}</button></div>

        </form>
    </div>
</div>
@push('child-scripts')
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
    $(document).ready(function () {
        $('#form_send_admission').on('submit', function () {
            localStorage.setItem('scrollPosition', $(window).scrollTop());
        });

        const scrollPosition = localStorage.getItem('scrollPosition');
        if (scrollPosition) {
            $(window).scrollTop(scrollPosition);
            localStorage.removeItem('scrollPosition');
        }
    });
</script>
@endpush
@push('scripts')
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
    $(document).ready(function () {
        $('#form_send_admission').on('submit', function () {
            localStorage.setItem('scrollPosition', $(window).scrollTop());
        });

        const scrollPosition = localStorage.getItem('scrollPosition');
        if (scrollPosition) {
            $(window).scrollTop(scrollPosition);
            localStorage.removeItem('scrollPosition');
        }
    });
</script>
@endpush