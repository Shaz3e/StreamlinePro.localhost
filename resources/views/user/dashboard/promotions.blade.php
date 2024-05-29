<div class="row">
    <div class="col-12">
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach ($promotions as $promotion)
                    <a href="" class="swiper-slide">
                        <img src="{{ asset('storage/' . $promotion->image) }}" alt="{{ $promotion->name }}" />
                    </a>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    {{-- /.col --}}
</div>
{{-- /.row --}}

@push('styles')
    <style>
        .swiper {
            width: 100%;
            padding: 50px 0;
        }

        .swiper-slide {
            position: relative;
            width: 200px;
            height: 500px;
            border-radius: 12px;
            overflow: hidden;
            transition: 1s;
            user-select: none;
        }

        .swiper-slide::after {
            content: "";
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg,
                    rgba(130, 13, 13, 0.8),
                    rgba(39, 8, 92, 0.8));
            mix-blend-mode: multiply;
            z-index: 1;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 1s;
        }

        .swiper-slide p {
            position: absolute;
            left: 20px;
            bottom: 10px;
            color: #fff;
            font-size: 1.3rem;
            font-weight: 600;
            font-style: italic;
            letter-spacing: 2px;
            z-index: 2;
            opacity: 0;
            transform: rotate(360deg) scale(0);
            transition: 0.8s;
        }

        .swiper-slide-active {
            position: relative;
            width: 350px;
            transition: 1s;
        }

        .swiper-slide-active::after {
            background: rgba(123, 123, 123, 0.4);
        }

        .swiper-slide-active img {
            transform: scale(1.3);
            object-position: 50% 0%;
        }

        .swiper-slide-active p {
            transform: rotate(0deg) scale(1);
            opacity: 1;
        }

        .swiper-pagination-bullet {
            width: 16px;
            height: 16px;
            background-color: #fff;
            border-radius: 50%;
            transition: all 0.6s ease-in-out;
        }

        .swiper-pagination-bullet-active {
            width: 32px;
            background-color: #6f1223;
            border-radius: 14px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".swiper", {
            grabCursor: true,
            initialSlide: 4,
            centeredSlides: true,
            slidesPerView: "auto",
            spaceBetween: 10,
            speed: 1000,
            freeMode: false,
            mousewheel: {
                thresholdDelta: 30,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            on: {
                click(event) {
                    swiper.slideTo(this.clickedIndex);
                },
            },
        });
    </script>
@endpush
