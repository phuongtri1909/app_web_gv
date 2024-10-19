@extends('pages.layouts.page')
@section('title', $tab->title)
@section('description', 'Description for Child Page')
@section('keyword', 'child, page, keywords')
@section('title-page', $tab->title)
@section('bg-page', asset($tab->banner))

@push('child-styles')
<style>
    #custom-page h2{
        color: #b70f1b;
    }
</style>
@endpush

@section('content-page')

    <section id="custom-page">
        <div class="custom-page">
            <div class="container-kids">
                <div class="row">
                    @if ($customs)
                        <div class="col-md-12">
                            <h2 class="title-introduce">
                                {{$customs->title}}
                            </h2>
                        </div>
                        <div class="col-md-12">
                            <p class="desc-custom">
                                {{$customs->description}}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p class="content-custom">
                                {!!$customs->content!!}
                            </p>
                        </div>
                    @else
                        <div class="col-md-12">
                            <p>{{ __('no_content_found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

@push('child-scripts')
@endpush
