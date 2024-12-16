@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Danh sách bộ câu hỏi - {{ $competition->title }}</h5>
                        </div>
                        <div>
                            <a href="{{ route('quizzes.create', $competition->id) }}" class="btn bg-gradient-primary">
                                <i class="fa fa-plus"></i> Thêm bộ câu hỏi
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        @if ($quizzes->count() > 0)
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{ __('STT') }}
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tiêu đề</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Số lượng câu hỏi</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Trạng thái</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{ __('Thao tác') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quizzes as $key => $quiz)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $quiz->title }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $quiz->quantity_question }}</p>
                                            </td>
                                            <td>
                                                <span id="status-badge-{{ $quiz->id }}"
                                                    class="badge badge-sm bg-{{ $quiz->status == 'active' ? 'success' : ($quiz->status == 'inactive' ? 'danger' : 'info') }}"
                                                    data-status="{{ $quiz->status }}">
                                                    {{ $quiz->status == 'active' ? 'Hoạt động' : ($quiz->status == 'inactive' ? 'Không hoạt động' : 'Hoàn thành') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('quizzes.edit', $quiz->id) }}"><i
                                                        class="fa-regular fa-pen-to-square"></i></a>
                                                <a href="{{ route('questions.index', $quiz->id) }}"
                                                    class="mx-2" title="Tạo câu hỏi">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                @include('admin.pages.components.delete-form', [
                                                    'id' => $quiz->id,
                                                    'route' => route('quizzes.destroy', $quiz->id),
                                                    'message' => __('Bạn có chắc chắn muốn xóa?'),
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <x-pagination :paginator="$quizzes" />
                        @else
                            <p class="text-center">Không có bộ câu hỏi nào.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
@endpush
