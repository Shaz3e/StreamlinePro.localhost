@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Knowledgebase',
        'breadcrumbs' => [
            ['text' => 'Knowledgebase Dashboard', 'link' => route('knowledgebase.dashboard')],
            [
                'text' => 'Category ' . $article->category->name,
                'link' => route('knowledgebase.categories', $article->category->slug),
            ],
        ],
    ])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $article->title }}</h4>
                </div>
                @if (!is_null($article->featured_image))
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->slug }}" class="img-fluid"
                        alt="{{ $article->title }}">
                @endif
                <div class="card-body">
                    {!! $article->content !!}
                </div>
                {{-- /.card-body --}}
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <p>
                                Listed in
                                @if ($article->category)
                                    <a href="{{ route('knowledgebase.categories', $article->category->slug) }}"
                                        class="card-link">{{ $article->category->name }}</a>
                                @else
                                    <a href="#" class="card-link">Uncategorized</a>
                                @endif
                                @foreach ($article->products as $product)
                                    <span class="badge bg-success">{{ $product->name }}</span>
                                @endforeach
                            </p>
                            <p>
                                Created By {{ ucfirst($article->author->name) }}
                            </p>

                        </div>
                        {{-- /.col --}}
                        <div class="col-6 text-end">
                            <p>Created at {{ $article->created_at->format('F j, Y, g:i A') }}</p>
                            <p>Modified at {{ $article->updated_at->format('F j, Y, g:i A') }}</p>
                        </div>
                        {{-- /.col --}}
                    </div>
                    {{-- /.row --}}
                </div>
                {{-- /.card-footer --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
