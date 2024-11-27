@extends('layouts.app')
@section('title', 'Đăng ký nhu cầu vốn')
@push('styles')
    <style>
        #registering-capital {
            position: relative;
            margin: 30px auto;
            /* padding: 20px 0px 20px 0px; */
            /* max-width: 800px; */
            background-color: #f8f9fa;
            border-radius: 8px;
            background: url('{{ asset('images/logo.png') }}') no-repeat;
            background-size: 30%;
            background-attachment: fixed;
            background-position: center center;
            z-index: 1;
        }

        form {
            position: relative;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.9);
            /* padding: 20px; */
            border-radius: 8px;
        }
    </style>
@endpush


@section('content')
    <section id="registering-capital">
        <div class="container my-4">
            <div class="row">
                <form action="{{ route('show.form.capital.need.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($slug))
                        <input type="hidden" id="slug" name="slug" value="{{ $slug }}">
                    @endif

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="finance">Số vốn đăng ký (VNĐ):<span class="text-danger">*</span></label>
                            <input type="number"
                                class="form-control form-control-sm @error('finance') is-invalid @enderror" id="finance"
                                name="finance" placeholder="VD: 5000000" value="{{ old('finance') }}"
                                min="0">
                            <span class="error-message"></span>
                            @error('finance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="loan_cycle">Chu kỳ vay (Tháng):<span class="text-danger">*</span></label>
                            <input type="number"
                                class="form-control form-control-sm @error('loan_cycle') is-invalid @enderror"
                                id="loan_cycle" name="loan_cycle" placeholder="Nhập chu kỳ vay (tháng)"
                                value="{{ old('loan_cycle') }}" min="0">
                            <span class="error-message"></span>
                            @error('loan_cycle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="interest_rate">Đề xuất lãi suất:<span class="text-danger">*</span></label>
                            <input type="number"
                                class="form-control form-control-sm @error('interest_rate') is-invalid @enderror"
                                id="interest_rate" name="interest_rate" placeholder="VD: 5.5"
                                value="{{ old('interest_rate') }}" min="0" step="0.1">
                            <span class="error-message"></span>
                            @error('interest_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="purpose">Mục đích vay vốn:<span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control form-control-sm @error('purpose') is-invalid @enderror" 
                                id="purpose"
                                name="purpose" 
                                placeholder="Nhập mục đích vay vốn">{{ old('purpose') }}</textarea>
                            <span class="error-message"></span>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="bank_connection">Đề nghị Kết nối ngân hàng (Tên ngân hàng):<span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('bank_connection') is-invalid @enderror"
                                id="bank_connection" name="bank_connection" placeholder="VD: National Citizen Bank"
                                value="{{ old('bank_connection') }}">
                            <span class="error-message"></span>
                            @error('bank_connection')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="support_policy">Đề xuất chính sách hỗ trợ của ngân hàng:<span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('support_policy') is-invalid @enderror" id="support_policy"
                                name="support_policy" placeholder="Nhập đề xuất chính sách hỗ trợ của ngân hàng">{{ old('support_policy') }}</textarea>
                            <span class="error-message"></span>
                            @error('support_policy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="feedback">Ý kiến đối với ngân hàng:<span
                                class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('feedback') is-invalid @enderror" id="feedback" name="feedback"
                                rows="3" placeholder="{{ __('Nhập phản hồi của bạn') }}">{{ old('feedback') }}</textarea>
                            @error('feedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>
                    @if ($errors->has('error'))
                        <div class="invalid-feedback d-block text-center" role="alert">{{ $errors->first('error') }}
                        </div>
                    @endif
                    <div id="recaptcha-error" class="text-danger text-center mt-2"></div>
                    <div class="text-center my-3">
                        <button type="submit" class="btn bg-app-gv rounded-pill text-white">Đăng ký</button>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="border border-custom rounded mb-3">
                            <div class="bg-business rounded-top py-2 px-3 mb-3">
                                <h5 class="mb-0 fw-bold text-dark">NCB Cộng Hòa</h5>
                            </div>
                            <div class="px-3">
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Địa chỉ:</p>
                                    <p class="mb-0">18H Cộng Hòa, Phường 4, Quận Tân Bình, Thành phố Hồ Chí Minh</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Số Fax:</p>
                                    <p class="mb-0">(08)38125351</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">GĐ chi nhánh:</p>
                                    <p class="mb-0">Trịnh Minh Châu</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Số điện thoại:</p>
                                    <p class="mb-0">0987.338339 - 0786.338339</p>
                                </div>
                                <hr>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Họ và tên:</p>
                                    <p class="mb-0">Dương Văn Thịnh</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Số điện thoại:</p>
                                    <p class="mb-0">0901967068</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Email:</p>
                                    <p class="mb-0">thinhdv1@ncb-bank.vn</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
