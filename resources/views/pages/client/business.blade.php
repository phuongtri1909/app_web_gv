@extends('pages.layouts.page')
@push('styles')
    <style>
        .badge-custom {
            position: relative;
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            background: linear-gradient(45deg, rgba(243, 236, 120, 0.5), rgba(175, 66, 97, 0.5));
            color: #000;
            z-index: 0;
            transition: transform 0.3s ease-in-out;
            animation: borderAnimation 3s infinite;
        }

        .badge-custom::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: inherit;
            background: inherit;
            z-index: -1;
            filter: blur(10px);
            animation: borderAnimation 3s infinite;
        }

        @keyframes borderAnimation {
            0% {
                background: linear-gradient(45deg, var(--color1), var(--color2));
            }

            50% {
                background: linear-gradient(45deg, var(--color2), var(--color1));
            }

            100% {
                background: linear-gradient(45deg, var(--color1), var(--color2));
            }
        }

        @keyframes hoverAnimation {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .badge-custom:hover {
            animation: hoverAnimation 0.6s infinite;
        }

        .border-custom {
            box-shadow: 0 0px 5px 1px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            border-color: rgb(236, 236, 236)
        }
    </style>
@endpush

@push('scripts')
    <script>
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = 'rgba(';
            for (let i = 0; i < 3; i++) {
                color += Math.floor(Math.random() * 256) + ',';
            }
            color += '0.5)';
            return color;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const badges = document.querySelectorAll('.badge-custom');
            badges.forEach(badge => {
                const color1 = getRandomColor();
                const color2 = getRandomColor();
                badge.style.setProperty('--color1', color1);
                badge.style.setProperty('--color2', color2);
                badge.style.background = `linear-gradient(45deg, ${color1}, ${color2})`;
            });
        });
    </script>
@endpush

@section('content')
    <section id="business" class="business mt-8rem">
        <div class="container">
            <h2 class="fw-bold">122 Doanh nghiệp</h2>
            <div class="category mt-3">
                <span class="badge badge-custom rounded-pill p-2 me-2 mb-2">Tất cả</span>
                @for ($i = 0; $i < 10; $i++)
                    <span class="badge badge-custom rounded-pill p-2 me-2 mb-2 badge-hidden">Dịch vụ phát triển
                        {{ $i }}</span>
                @endfor
            </div>

            <div class="list-business mt-5">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-5 g-1 g-md-3">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="col">
                            <a href="{{ route('business.detail','business') }}" class="card h-100 border-custom">
                                <img src="{{ asset('images/logo-hoi-doanh-nghiep.png') }}"
                                    class="card-img-top img-fluid p-1" alt="...">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title text-uppercase text-dark">Card title</h6>
                                </div>
                            </a>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>
@endsection
