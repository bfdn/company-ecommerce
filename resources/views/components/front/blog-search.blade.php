@props(['searchText' => ''])
<!-- Search Field  -->
<div class="blog__sidebar--item">
    <form action="{{ route('front.blogSearch') }}">
        <div class="blog__search-field">

            <input type="text" name="q" placeholder="{{ __('front.search') }}..." value="{{ $searchText }}" />
            <div class="icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M9.80577 17.2971C13.9428 17.2971 17.2966 13.9433 17.2966 9.80626C17.2966 5.66919 13.9428 2.31543 9.80577 2.31543C5.6687 2.31543 2.31494 5.66919 2.31494 9.80626C2.31494 13.9433 5.6687 17.2971 9.80577 17.2971Z"
                        stroke="#1A1A1A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M15.0149 15.4043L17.9516 18.3335" stroke="#1A1A1A" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

        </div>
    </form>
</div>
