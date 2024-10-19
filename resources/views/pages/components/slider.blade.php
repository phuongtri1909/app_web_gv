<section id="slider">
    <div class="discover home-slider ">
        @if ($sliders->isNotEmpty())
            <ul class="bxslider">
                @foreach ($sliders as $post)
                        <li>
                            <div>
                                <div class="title-slider">
                                    <h4>
                                        <span>
                                            {{ $post->slider_title }}
                                        </span>
                                    </h4>
                                </div>
                                <div class="discover-post">
                                    <div class="discover-img" style="background-image: url('{{ asset($post->image_slider) }}');">
                                    </div>
                                    <div class="discover-content">
                                        <div class="container">
                                            <div class="discover-content-inner">
                                                <h2>{{ $post->title }} @if (!empty($post->subtitle))
                                                        <br>
                                                        <font>{{ $post->subtitle }}</font>
                                                    @endif
                                                </h2>
                                                <p>{{ $post->description }}</p>

                                                <div class="discover-btn">
                                                    <a href="{{ $post->learn_more_url }}" class="primary-btn">
                                                        <span>{{ __('learn_more') }}<i class="arrow"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                @endforeach
            </ul>
        @endif
    </div>
</section>
