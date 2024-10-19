@extends('pages.layouts.page')
@section('title', $tab->title)
@section('description', $tab->title . ' page, ' . $tab->title . ' Brighton Academy, ' . $tab->slug . ' Brighton
    Academy')
@section('keyword', $tab->title . ' page, ' . $tab->title . ' Brighton Academy, ' . $tab->slug . ' Brighton Academy')
@section('title-page', $tab->title)
@section('bg-page', asset($tab->banner))
@push('child-styles')
@endpush
@section('content-page')
    <div id="admission">
        <div class="container">

            @if (!isset($tab_img_contents))
                <div class="content-table-contact my-5 text-center">
                    <div class="alert alert-danger" role="alert">
                        {{ __('Not yet', ['tab' => $tab->title]) }}
                    </div>
                </div>
            @else
                @if (isset($admission))
                    @include('pages.notification.success-error')

                    @foreach ($tab_img_contents as $tab_img_content)
                        <div class="content-table-contact text-center mb-100">
                            <div class="mt-5 mb-5">
                                <h2 style="color: #b70f1b">
                                    {{ $tab_img_content->title }}
                                </h2>
                                <p class="mt-5">{{ $tab_img_content->content }}</p>
                            </div>
                            <div>
                                @if (!empty($tab_img_content->image))
                                    <div>
                                        <img class="img-fluid" src="{{ asset($tab_img_content->image) }}"
                                            alt="{{ $tab_img_content->title }}">
                                    </div>
                                @else
                                    <div class="alert alert-danger" role="alert">
                                        {{ __('Not yet', ['tab' => $tab_img_content->title]) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="content-table-contact mb-5">
                        <div class="mt-5 mb-3">
                            <h3 style="color: #b70f1b">
                                {{ __('admission') }}
                            </h3>
                        </div>

                        @include('pages.components.send-admission', [
                            'content' => __('to view') . $tab->title,
                        ])

                    </div>
                @endif

            @endif

            {{-- <div class="tuition-table">
                <div class="mt-5 mb-3">
                    <h3 style="color: #b70f1b" class="mb-3">
                        {{ __('table-tuition') }}
                    </h3>

                    <div class="table-responsive">
                        <table class="table table-custom table-bordered ">
                            <tbody>
                                <tr>
                                    <td width="10%" class="text-center bg-th">
                                        <strong class="cl-red">{{ __('stt') }}</strong>
                                    </td>
                                    <td width="35%" class="text-center bg-th">
                                        <strong class="cl-red">{{ __('list') }}</strong>
                                    </td>
                                    <td width="20%" class="text-center bg-th">
                                        <strong class="cl-red">{{ __('tuition') }}</strong>
                                    </td>
                                    <td width="35%" class="text-center bg-th">
                                        <strong class="cl-red">{{ __('note') }}</strong>
                                    </td>
                                </tr>
                                @foreach ($tuitions as $tuition)
                                    @if ($tuition->title == null)
                                        <tr>
                                            <td width="10%" class="text-center bg-th" rowspan="{{ $tuition->count}}">{{ $tuition->numerical_order }}</td>
                                            @foreach ($tuition->content as $index => $content)
                                                @if ($index > 0)
                                                    <tr>
                                                @endif
                                                    <td width="35%" class="text-start">
                                                        <strong>{{ $content->list }}</strong>
                                                    </td>
                                                    <td width="20%" class="text-center ">
                                                        <strong class="cl-red">{{ $content->cost }}</strong>
                                                    </td>
                                                    <td width="35%">{{ $content->note }}</td>
                                                </tr>
                                            @endforeach
                                        </tr>
                                    @else
                                        <tr>
                                            <td width="10%" class="text-center bg-th" rowspan="{{ $tuition->count +1 }}">{{ $tuition->numerical_order }}</td>
                                            <td width="35%" class="text-start" colspan="3">
                                                <strong>{{ $tuition->title }}</strong>
                                            </td>
                                        </tr>
                                        @foreach ($tuition->content as $content)
                                            <tr>
                                                <td width="35%" class="text-start">
                                                    <strong>{{ $content->list }}</strong>
                                                </td>
                                                <td width="20%" class="text-center ">
                                                    <strong class="cl-red">{{ $content->cost }}</strong>
                                                </td>
                                                <td width="35%">{{ $content->note }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
@push('child-scripts')
@endpush
