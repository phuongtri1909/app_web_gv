@extends('admin.layouts.app')

@push('styles-admin')
<!-- Thêm các style tùy chỉnh nếu cần -->
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">{{ __('slide_program_list') }}</h5>
                    </div>
                    <a href="{{ route('slide_programs.create', ['program_id' => $program_id] ) }}" class="btn bg-gradient-primary btn-sm mb-0 px-2"
                        type="button">
                        <i class="fa-solid fa-plus"></i> {{ __('add_slide_program') }}
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                @include('admin.pages.notification.success-error')

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('id') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{ __('program_id') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('img') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($slidePrograms as $slideProgram)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-xs font-weight-bold mb-0">{{ $slideProgram->id }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $slideProgram->program_id }}</p>
                                </td>
                                <td class="text-center">
                                    @if ($slideProgram->img)
                                    <img src="{{ asset($slideProgram->img) }}" alt="{{ $slideProgram->programOverview->title_program }}"
                                        style="max-width: 100px;">
                                    @else
                                    <p>{{ __('No image available') }}</p>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('slider_prog.edit', $slideProgram->id) }}" class="mx-3"
                                        title="{{ __('edit') }}">
                                        <i class="fa-solid fa-pencil"></i>
                                     </a>
                                    @include('admin.pages.components.delete-form', ['id' =>  $slideProgram->id, 'route' => route('slide_program.destroy', $slideProgram->id)])
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')
<!-- Thêm các script tùy chỉnh nếu cần -->
@endpush
