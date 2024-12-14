@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Chi tiết tiếp dân</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Phiếu STT:</strong>
                            </div>
                            <div class="col-md-9">
                                <strong>STT: </strong><h4>{{ $work_schedule->stt }}</h4>
                                <strong>Code: </strong>{{ $work_schedule->code }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Thông tin:</strong>
                            </div>
                            <div class="col-md-9">
                                <p>
                                    <strong>Họ và tên: </strong>{{ $work_schedule->fullname }}<br>
                                    <strong>Số điện thoại: </strong> {{ $work_schedule->phone }}<br>
                                    <strong>CCCD: </strong> {{ $work_schedule->card_number }}<br>
                                    <strong>Địa chỉ: </strong> {{ $work_schedule->address }}
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Phòng ban:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $work_schedule->department->name }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Mô tả:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $work_schedule->description }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Ngày làm việc:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $work_schedule->working_day }}
                                <br>
                                <span class="badge
                                    @if (\Carbon\Carbon::parse($work_schedule->working_day)->isToday())
                                        bg-success text-white
                                    @elseif (\Carbon\Carbon::parse($work_schedule->working_day)->isFuture())
                                        bg-warning text-dark
                                    @else
                                        bg-danger text-white
                                    @endif">
                                    @if (\Carbon\Carbon::parse($work_schedule->working_day)->isToday())
                                        Đã đến ngày làm việc
                                    @elseif (\Carbon\Carbon::parse($work_schedule->working_day)->isFuture())
                                        Chưa tới ngày làm việc
                                    @else
                                        Đã qua ngày làm việc
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Trạng thái:</strong>
                            </div>
                            <div class="col-md-9">
                                <form action="{{ route('work-schedules.update', $work_schedule->id) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-control">
                                        <option value="approved" {{ $work_schedule->status == "approved" ? 'selected' : '' }}>Đã làm việc</option>
                                        <option value="pending" {{ $work_schedule->status == "pending" ? 'selected' : '' }}>Chưa làm việc</option>
                                        <option value="rejected" {{ $work_schedule->status == "rejected" ? 'selected' : '' }}>Hủy lịch</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
@endpush