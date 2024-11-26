<div class="wrap-button" title="{{ $buttonTitle ?? 'Đăng ký' }}" style="{{ $buttonPosition ?? 'right:10px' }}">
    <a href="{{ $buttonLink }}" class="circle-button text-white bg-app-gv"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>
    <div class="marquee-text">
        <a href="{{ $buttonLink }}" class="text-dark text">{{ $buttonTitle }}</a>
    </div>
</div>

@push('styles')
    <style>
        .circle-button {
            display: inline-block;
            padding: 14px;
            font-size: 12px;
            font-weight: bold;
            color: white;
            text-decoration: none;
            border-radius: 50%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }

        .circle-button:hover i {
            animation: blink 0.3s step-start infinite;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }

        .marquee-text {
            width: 44px;
            overflow: hidden;
            position: relative;
            white-space: nowrap;
        }

        .marquee-text .text {
            display: inline-block;
            animation: marquee 5s linear infinite;
        }

        @keyframes marquee {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(-100%);
            }
        }
    </style>
@endpush

