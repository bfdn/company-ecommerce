@props(['lastArticles'])
<!-- Recent Added Products  -->
<div class="blog__sidebar--item">
    <h5 class="font-body--xxl-500">{{ __('front.recently_added') }}</h5>
    <div class="blog__recent-product">
        @foreach ($lastArticles as $lastArticle)
            <a href="#" class="blog__recent-product__item">
                <div class="blog__recent-product__img-wrapper">
                    <img src="{{ asset($lastArticle->image) }}" alt="{{ $lastArticle->name }}" />
                </div>
                <div class="blog__recent-product__item-info">
                    <h5 class="font-body--lg-500">
                        {{ $lastArticle->name }}
                    </h5>
                    <div class="date">
                        <span class="icon">
                            <svg width="18" height="19" viewBox="0 0 18 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.25 3.5H3.75C2.92157 3.5 2.25 4.17157 2.25 5V15.5C2.25 16.3284 2.92157 17 3.75 17H14.25C15.0784 17 15.75 16.3284 15.75 15.5V5C15.75 4.17157 15.0784 3.5 14.25 3.5Z"
                                    stroke="#00B307" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 2V5" stroke="#00B307" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6 2V5" stroke="#00B307" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M2.25 8H15.75" stroke="#00B307" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>
                        <p>{{ date('d/m/Y', strtotime($lastArticle->created_at)) }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
