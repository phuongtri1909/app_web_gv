@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Danh sách phòng ban</h5>
                        </div>
                    </div>
                    <form>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <select name="search-status" class="form-control form-control-sm">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="approved" {{ request('search-status') == "approved" ? 'selected' : '' }}>Đã làm việc</option>
                                    <option value="pending" {{ request('search-status') == "pending" ? 'selected' : '' }}>Chưa làm việc</option>
                                    <option value="rejected" {{ request('search-status') == "rejected" ? 'selected' : '' }}>Hủy lịch</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="search-date" class="form-control form-control-sm"
                                    value="{{ request('search-date', \Carbon\Carbon::today()->toDateString()) }}">
                            </div>
                            <div class="col-md-3">
                                <select name="search-department_id" class="form-control form-control-sm">
                                    <option value="">Tất cả phòng ban</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ request('search-department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Phiếu STT</th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Thông tin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Phòng ban') }}</th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Ngày làm việc</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Trạng thái</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Thao tác') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($work_schedules as $key => $item)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">
                                                <strong>
                                                    <h5 class="mb-0">{{ $item->stt }}</h5>
                                                </strong>
                                                <br>
                                                <strong>{{ $item->code }}</strong>
                                            </p>
                                        </td>

                                        <td>
                                            <p class="text-xs  mb-0">
                                                <strong>{{ $item->fullname }}</strong>
                                                <br>
                                                <strong>CCCD: </strong> {{ $item->card_number }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                <strong>{{ $item->department->name }}</strong>
                                            </p>
                                        </td>

                                        <td>
                                            <p
                                                class="text-xs font-weight-bold mb-0 badge
                                                @if (\Carbon\Carbon::parse($item->working_day)->isToday()) bg-success text-white
                                                @elseif (\Carbon\Carbon::parse($item->working_day)->isFuture())
                                                    bg-warning text-dark
                                                @else
                                                    bg-danger text-white @endif">
                                                {{ $item->working_day }}
                                                <br>
                                                @if (\Carbon\Carbon::parse($item->working_day)->isToday())
                                                    Đã đến ngày làm việc
                                                @elseif (\Carbon\Carbon::parse($item->working_day)->isFuture())
                                                    Chưa tới ngày làm việc
                                                @else
                                                    Đã qua ngày làm việc
                                                @endif
                                            </p>
                                        </td>

                                        <td>
                                            <span
                                                class="badge
                                                @if ($item->status == 1) bg-success text-white
                                                @else
                                                    bg-danger text-white @endif">
                                                @if ($item->status == 1)
                                                    Đã làm việc
                                                @else
                                                    Chưa làm việc
                                                @endif
                                            </span>

                                        <td class="text-center">
                                            <a target="_blank" href="{{ route('work-schedules.show', $item->id) }}"
                                                class="text-secondary font-weight-bold text-xs">
                                                <span class="badge bg-gradient-success">Xem</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$work_schedules" />

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts-admin')
@endpush
