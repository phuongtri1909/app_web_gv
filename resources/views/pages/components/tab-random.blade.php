<section id="random">
    <div class="container my-5">
        <h3 class="text-center" style="color: #b70f1b">{{ __('page suggestions') }}</h3>
        <div class="row">
            @foreach ($page_suggestions as $item)
                @php
                    $route = '';
                    switch ($item->key_page) {
                        case 'about-us':
                            $route = route('page.aboutUs.detail', ['slug' => $item->slug]);
                            break;
                        case 'environment':
                            $route = route('tab.environment', ['slug' => $item->slug]);
                            break;
                        case 'admissions':
                            $route = route('tab.admission', ['slug' => $item->slug]);
                            break;
                        case 'programs':
                            $route = route('programms', ['slug' => $item->slug]);
                            break;
                        case 'parent':
                            $route = route('tab.parent', ['slug' => $item->slug]);
                            break;
                        case 'advisory-board':
                            $route = route('advisory-board');
                            break;
                        default:
                            $route = '#';
                            break;
                    }
                @endphp
                <a href="{{ $route }}" class="col-12 col-md-3 col-sm-6 mb-5">
                    <div class="card card-block">
                        <img src="{{ asset($item->banner) }}" alt="Photo of sunset" class="img-fluid">
                        <h5 class="card-title m-3 text-dark">{{ $item->title }}</h5>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
