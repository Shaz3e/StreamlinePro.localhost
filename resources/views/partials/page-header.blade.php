<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">{{ $title }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @foreach($breadcrumbs as $breadcrumb)
                        @if($breadcrumb['link'])
                            <li class="breadcrumb-item"><a href="{{ $breadcrumb['link'] }}">{{ $breadcrumb['text'] }}</a></li>
                        @else
                            <li class="breadcrumb-item active">{{ $breadcrumb['text'] }}</li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
