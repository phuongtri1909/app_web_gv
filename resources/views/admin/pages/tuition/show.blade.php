@extends('admin.layouts.app')

@push('styles-admin')
@endpush
@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('show_tuition') }} :  {{__('numerical_order'). ' : '. $tuition->numerical_order }}</h5>
                        </div>
                        <a href="{{ route('content-tuitions.create',$tuition->id) }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button"><i class="fa-solid fa-plus"></i> {{ __('new_content_tuition') }}</a>
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
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('list') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('cost') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('note') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('date') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($contents_tuition)
                                    @foreach ($contents_tuition as $content)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $content->id }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $content->list }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $content->cost }}</p>
                                            </td>
                                            <td class="text-center" style="white-space: normal;width:250px">
                                                <p class="text-xs font-weight-bold mb-0">{{ $content->note }}</p>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{__('create').' : '. $content->created_at }}</span>
                                                <br>
                                                <span class="text-secondary text-xs font-weight-bold">{{__('update').' : '. $content->updated_at }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('content-tuitions.edit',$content->id) }}" class="mx-3" title="{{ __('edit') }}">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </a>
                                                @include('admin.pages.components.delete-form', ['id' => $content->id, 'route' => route('content-tuitions.destroy', $content->id)])
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('no_content_available') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts-admin')
@endpush
