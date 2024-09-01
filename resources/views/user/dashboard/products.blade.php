<div class="row">
    <div class="col-12">
        <div class="card-title">
            <h4>My Products</h4>
        </div>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-3 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $product->name }}</h4>
                        </div>
                        {{-- /.card-body --}}
                    </div>
                    {{-- /.card --}}
                </div>
                {{-- /.col --}}
            @endforeach
        </div>
        {{-- /.row --}}
    </div>
    {{-- /.col --}}
</div>
{{-- /.row --}}
