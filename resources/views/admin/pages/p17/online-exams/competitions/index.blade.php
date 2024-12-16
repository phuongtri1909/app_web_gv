@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .import-container {
            border-radius: 5px;
            max-width: 400px;
            text-align: center;
        }

        .file-upload input[type="file"] {
            display: none;
        }

        .file-upload {
            margin-right: 10px;
        }

        .file-upload label {
            display: inline-block;
            padding: 6px 15px;
            border: 1px solid #007bff;
            color: #007bff;
            cursor: pointer;
            border-radius: 5px;
        }

        .file-upload label:hover {
            background-color: #007bff;
            color: white;
        }

        .file-name-icon {
            display: inline-flex;
            align-items: center;
            margin-left: 10px;
            padding: 5px 10px;
            border: 1px solid #007bff;
            background-color: #f0f8ff;
            color: #007bff;
            border-radius: 5px;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .file-name-icon i {
            margin-right: 5px;
            font-size: 1rem;
            color: #007bff;
        }
    </style>
@endpush
@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ $type == 'survey' ? 'Danh sách khảo sát' : 'Danh sách cuộc thi' }}</h5>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="import-container d-flex">
                                <form id="importForm" action="{{ route('competitions.import') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex">
                                        <div class="file-upload">
                                            <input type="file" name="file" id="fileInput" accept=".csv,.xls,.xlsx"
                                                required>
                                            <label for="fileInput">Chọn file Excel</label>
                                        </div>
                                        <div class="button-submit">
                                            <button type="submit" class="btn btn-primary btn-sm mb-0">Tải lên</button>
                                        </div>
                                    </div>
                                    <span id="fileName" class="file-name-icon" style="display: none;">
                                        <i class="fa fa-file" aria-hidden="true"></i>
                                        <span id="fileNameText"></span>
                                    </span>
                                </form>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('competitions.create') }}" class="btn bg-gradient-primary">Thêm cuộc thi</a>
                        </div>
                    </div>
                    <div id="progress-container" style="display: none;">
                        <h5>Đang xử lý...</h5>
                        <div class="progress">
                            <div id="progress-bar" class="progress-bar" style="width: 0%;"></div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('STT') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tên cuộc thi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Ngày bắt đầu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Ngày kết thúc</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Trạng thái</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Thao tác') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($competitions as $key => $competition)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $competition->title }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $competition->start_date }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $competition->end_date }}</p>
                                        </td>
                                        <td>
                                            <span id="status-badge-{{ $competition->id }}"
                                                class="badge badge-sm bg-{{ $competition->status == 'active' ? 'success' : ($competition->status == 'inactive' ? 'danger' : 'info') }}"
                                                data-status="{{ $competition->status }}">
                                                {{ $competition->status == 'active' ? 'Hoạt động' : ($competition->status == 'inactive' ? 'Không hoạt động' : 'Hoàn thành') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('competitions.edit', $competition->id) }}"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                            <a href="{{ route('quizzes.index', $competition->id) }}" class="mx-2"
                                                title="Tạo bộ câu hỏi">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $competition->id,
                                                'route' => route('competitions.destroy', $competition->id),
                                                'message' => __('Bạn có chắc chắn muốn xóa?'),
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$competitions" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        $("#fileInput").change(function() {
            const fileNameDisplay = $("#fileName");
            const fileNameText = $("#fileNameText");
            const fileInput = $(this).prop("files")[0];

            if (fileInput) {
                fileNameDisplay.show();
                fileNameText.text(fileInput.name);
            } else {
                fileNameDisplay.hide();
                fileNameText.text("");
            }
        });

        $("#importForm").submit(function(e) {
            const fileInput = $("#fileInput").prop("files")[0];
            if (!fileInput) {
                e.preventDefault();
                alert("Vui lòng chọn một file trước khi tải lên.");
                return;
            }

            $("#progress-container").show();
            const progressBar = $("#progress-bar");
            let width = 0;
            const interval = setInterval(() => {
                if (width >= 100) {
                    clearInterval(interval);
                } else {
                    width += 10;
                    progressBar.css("width", width + "%");
                }
            }, 500);
        });
    </script>
@endpush
