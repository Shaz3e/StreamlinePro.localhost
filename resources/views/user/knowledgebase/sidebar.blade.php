<div class="email-leftbar card">
    <div class="mail-list">
        @foreach ($knowledgebaseCategories as $category)
            <a href="{{ route('knowledgebase.categories', $category->slug) }}" class="">
                <i class="ri ri-arrow-right-s-line me-2"></i> {{ $category->name }}
            </a>
        @endforeach

    </div>
</div>
{{-- email-leftbar --}}
