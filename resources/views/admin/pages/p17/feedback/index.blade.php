@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Danh sách góp ý</h5>
                        </div>
                    </div>
                    <form>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input type="date" name="search-date" class="form-control form-control-sm"
                                    value="{{ request('search-date') }}">
                            </div>

                            

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table table-striped align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        STT</th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tiêu đề</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nội dung</th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Hình ảnh</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feedbacks as $key => $item)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $key + 1 }}
                                            </p>
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $item->name }}
                                            </p>
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $item->description }}
                                            </p>
                                        </td>

                                        <td>
                                            @if ($item->feedbackImages->count() > 0)
                                                @foreach ($item->feedbackImages as $image)
                                                    <a href="{{ asset($image->imageUrl) }}"
                                                        data-fancybox="gallery-{{ $image->id }}">
                                                        <img src="{{asset($image->imageUrl)  }}" alt=""
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                    </a>
                                                @endforeach
                                            @endif
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $item->created_at }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$feedbacks" />

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts-admin')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
@endpush
