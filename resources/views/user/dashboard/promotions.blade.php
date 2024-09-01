<div class="row mb-5">
    <div class="col-12">
        <div id="carouselPromotions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" role="listbox">
                @foreach ($promotions as $promotion)
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/' . $promotion->image) }}" alt="..." class="d-block img-fluid">
                        <div class="carousel-caption d-none d-md-block text-white-50">
                            {{-- <h5 class="text-white">{{ $promotion->name }}</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> --}}
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselPromotions" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselPromotions" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    {{-- /.col --}}
</div>
{{-- /.row --}}

@push('styles')
@endpush

@push('scripts')
@endpush
