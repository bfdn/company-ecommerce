@props(['blogCategories'])
<!-- Top Categories  -->
<div class="blog__sidebar--item">
    <h5 class="font-body--xxl-500">{{ __('front.categories') }}</h5>
    <div class="blog__top-categories">
        @foreach ($blogCategories as $blogCategory)
            <a href="{{ route('front.blogCategoryList', ['category' => $blogCategory->slug]) }}"
                class="blog__top-categories-item">
                <p class="font-body--md-400">{{ $blogCategory->name }}</p>
                <p class="font-body--md-400 number">({{ $blogCategory->articles->count() }})
                </p>
            </a>
        @endforeach
    </div>
</div>
