@push('styles')
    <style>
        :root {
            --bg: #fff;
            --text: #7288a2;
            --gray: #4d5974;
            --lightgray: #e5e5e5;
            --blue: #03b5d2;
        }

        .accordion .accordion-item {
            border-bottom: 1px solid var(--lightgray);
        }

        .accordion .accordion-item button[aria-expanded='true'] {
            border-bottom: 1px solid var(--blue);
        }

        .accordion button {
            position: relative;
            display: block;
            text-align: left;
            width: 100%;
            padding: 1em 0;
            color: var(--text);
            font-size: 1.15rem;
            font-weight: 400;
            border: none;
            background: none;
            outline: none;
            transition: color 0.3s ease;
        }

        .accordion button:hover,
        .accordion button:focus {
            cursor: pointer;
            color: var(--blue);
        }

        .accordion button:hover::after,
        .accordion button:focus::after {
            cursor: pointer;
            color: var(--blue);
            border: 1px solid var(--blue);
        }

        .accordion button .accordion-title {
            padding: 1em 1.5em 1em 0;
        }

        .accordion button .icon {
            display: inline-block;
            position: absolute;
            top: 50%;
            right: 10px;
            width: 22px;
            height: 22px;
            border: 1px solid;
            border-radius: 22px;
            transform: translateY(-50%);
        }

        .accordion button .icon::before {
            display: block;
            position: absolute;
            content: '';
            top: 9px;
            left: 5px;
            width: 10px;
            height: 2px;
            background: currentColor;
        }

        .accordion button .icon::after {
            display: block;
            position: absolute;
            content: '';
            top: 5px;
            left: 9px;
            width: 2px;
            height: 10px;
            background: currentColor;
            transition: width 0.3s ease;
        }

        .accordion button[aria-expanded='true'] {
            color: var(--blue);
        }

        .accordion button[aria-expanded='true'] .icon::after {
            width: 0;
        }

        .accordion button[aria-expanded='true']+.accordion-content {
            opacity: 1;
            max-height: inherit;
            transition: all 200ms linear;
            will-change: opacity, max-height;
        }

        .accordion .accordion-content {
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: opacity 200ms linear, max-height 200ms linear;
            will-change: opacity, max-height;
        }

        .accordion .accordion-content p {
            font-size: 1rem;
            font-weight: 300;
            margin: 2em 0;
        }

        #component-collapse .image-container {
            position: relative;
            display: inline-block;
            margin: 20px;
        }

        #component-collapse .image-container .star {
            position: absolute;
            top: 2px;
            left: 44%;
            transform: translateX(-50%);
            padding: 0px;
            border-radius: 50%;
            color: #db2d48;
        }

        #component-collapse .image-container .curve {
            position: absolute;
            width: 210px;
            height: 93px;
            top: 11%;
            left: 26%;
            border: dotted 5px #db2d48;
            border-color: #db2d48 transparent transparent transparent;
            border-radius: 59% / 100px 100px 0 0;
            transform: rotate(37deg);
        }

        #component-collapse .image-container .curve::after {
            content: "";
            position: absolute;
            width: 207px;
            height: 92px;
            left: -3%;
            top: 164%;
            border: dotted 5px #db2d48;
            border-color: #db2d48 transparent transparent transparent;
            border-radius: 59% / 100px 100px 0 0;
            transform: rotate(181deg);
        }

        .show-img-experience img {
            height: 262px;
            width: 262px;
            padding: 25px;
            border-radius: 50%;
        }

        .kids-flex {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media screen and (max-width: 425px) {
            #component-collapse .image-container .curve {
                position: absolute;
                width: 138px;
                height: 94px;
                top: 6%;
                left: 17%;
                border: dotted 5px #db2d48;
                border-color: #db2d48 transparent transparent transparent;
                border-radius: 70% / 100px 100px 0 0;
                transform: rotate(39deg);
            }

            #component-collapse .image-container .curve::after {
                content: "";
                position: absolute;
                width: 138px;
                height: 93px;
                left: -3%;
                top: 61%;
                border: dotted 5px #db2d48;
                border-color: #db2d48 transparent transparent transparent;
                border-radius: 70% / 100px 100px 0 0;
                transform: rotate(178deg);
            }

            #component-collapse .image-container .star {
                top: -3px;
                left: 41%;
            }

        }
    </style>
@endpush
<section id="component-collapse" class="container my-5">
    <div class="accordion">
        @foreach ($collapses as $item)
            <div class="accordion-item">
                <button class="px-3" id="accordion-button-1" aria-expanded="false"><span
                        class="accordion-title">{{ $item->title }}</span><span class="icon"
                        aria-hidden="true"></span></button>
                <div class="accordion-content px-3">
                    <div class="row">
                        <div class="col-lg-4 order-1">
                            <div class="show-img-experience image-container">
                                <img src="{{ asset($item->image) }}" alt="Kids-edu">
                                <div class="star">★</div>
                                <div class="curve"></div>
                            </div>
                        </div>
                        <div class="col-lg-8 kids-flex">
                            <div class="show-detail-experience">
                                <p class="show-descr-experience">
                                    {{ $item->content }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@push('scripts')
    <script>
        const items = document.querySelectorAll(".accordion button");

        function toggleAccordion() {
            const itemToggle = this.getAttribute('aria-expanded');

            for (i = 0; i < items.length; i++) {
                items[i].setAttribute('aria-expanded', 'false');
            }

            if (itemToggle == 'false') {
                this.setAttribute('aria-expanded', 'true');
            }
        }

        items.forEach(item => item.addEventListener('click', toggleAccordion));
    </script>
@endpush
