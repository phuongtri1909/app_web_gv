@extends('pages.layouts.page')
@section('title', $tab->title)
@section('description',
    $tab->title .
    ' page, ' .
    $tab->title .
    ' Brighton Academy, ' .
    $tab->slug .
    ' Brighton
    Academy')
@section('keyword', $tab->title . ' page, ' . $tab->title . ' Brighton Academy, ' . $tab->slug . ' Brighton Academy')
@section('title-page', $tab->title)
@section('bg-page', asset($tab->banner))
@push('child-styles')
    <style>
        .component2 .content {
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);

            overflow: hidden;
            position: relative;
        }

        .component2 .desc-content {
            text-align: justify;
            display: -webkit-box;
            -webkit-line-clamp: 7;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
            transition: max-height 0.3s ease;
        }

        .show-more {
            max-height: none;
            -webkit-line-clamp: unset;
        }


        .title-content {
            color: #b70f1b;
        }

        @media (min-width: 768px) {

            .component2 .content {
               padding-right: 4.9rem !important;
                height: 350px;
                max-height: 350px;
            }

            .component2 .content-left{
                padding-left: 6rem !important;
            }

            .component2 .content-right{
                padding-right: 6rem !important;
            }

            .component2 .show-content {
                position: relative;
            }

            .component2 .img-content img {
                object-fit: cover;
                width: 100%;
                height: 80%;
            }

            .component2 .img-content {
                position: absolute;
                top: 50%;
                width: 100%;
                height: 100%;
                transform: translateY(-50%);
            }

            .component2 .img-content-right {
                left: 90%;
            }

            .component2 .img-content-left {
                right: 90%;
            }
        }

        .modal-content {
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
@endpush
@section('content-page')

    @if ($component_2 != null)
        <section id="component1" class="container mt-5 mb-100">
            <div class="introduce">
                <div class="container-kids text-center">
                    <h2 class="title-content">
                        {{ $component_2->title }}
                    </h2>
                    <br>
                    <p class="desc-introduce">
                        {!! $component_2->content !!}
                    </p>
                </div>
            </div>
        </section>
    @endif

    @if ($components_3 != null)
        @foreach ($components_3 as $index => $item)
            <section class="component2 container mb-100">
                    <div class="row">
                        @if ($index % 2 == 0)
                           <div class="col-md-6"></div>
                        @endif
                        <div class="col-md-6 show-content">
                            <div class="content p-3 p-md-5 {{ $index % 2 == 0 ? 'content-left' : 'content-right' }}">
                                <h2 class="title-content text-center">
                                    {{ $item->title }}
                                </h2>
                                <p class="desc-content mb-0">
                                    {!! $item->content !!}
                                </p>

                                <button type="button" class="btn btn-sm btn-dark view-more-btn mt-3" data-bs-toggle="modal"
                                    data-bs-target="#contentModal" data-title="{{ $item->title }}"
                                    data-content="{!! $item->content !!}">
                                    {{ __('read_more') }}
                                </button>

                            </div>
                            <div class="img-content {{ $index % 2 == 0 ? 'img-content-left' : 'img-content-right' }}">
                                <img src="{{ asset($item->image) }}" alt="" class="img-content w-100">
                            </div>
                        </div>
                    </div>
            </section>
        @endforeach
        <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title title-content " id="modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalContent">
                        <!-- Nội dung sẽ được load ở đây -->
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
@push('child-scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.view-more-btn', function() {
                const title = $(this).data('title');
                const content = $(this).data('content');

                // Đổ dữ liệu vào modal
                $('#modalTitle').html(title);
                $('#modalContent').html(content);
            });
        });
    </script>
@endpush
