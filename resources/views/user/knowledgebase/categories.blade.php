@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Knowledgebase',
        'breadcrumbs' => [
            ['text' => 'Knowledgebase Dashboard', 'link' => route('knowledgebase.dashboard')],
            ['text' => 'Category ' . $currentCategory->name, 'link' => null],
        ],
    ])

    <div class="row">
        <div class="col-12">

            @include('user.knowledgebase.sidebar')

            {{-- Right Sidebar --}}
            <div class="email-rightbar mb-3">
                @foreach ($knowledgebaseArticles as $article)
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="{{ route('knowledgebase.article', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h4>
                        </div>
                        <div class="card-body">
                            {{ shortTextWithOutHtml($article->content) }}
                        </div>
                        {{-- /.card-body --}}
                    </div>
                    {{-- /.card --}}
                @endforeach

                {{ $knowledgebaseArticles->links('pagination::bootstrap-5') }}
            </div>
            {{-- /.email-rightbar --}}

        </div>
        {{-- /.col --}}

    </div>
    {{-- /.row --}}
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
