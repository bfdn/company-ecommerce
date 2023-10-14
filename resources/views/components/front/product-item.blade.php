@props(['product', 'class'])

<div class="cards-md {{ $class ?? '' }}">
    {{-- <div class="cards-md {{ $attributes->get('class') }}"> --}}
    {{-- <div {{ $attributes->merge(['class' => 'cards-md']) }}> --}}
    {{-- <div {{ $attributes->class(['cards-md']) }}> --}}
    <div class="cards-md__img-wrapper">
        <a href="{{ route('front.productDetail', ['product' => $product->slug]) }}">
            @php $images = json_decode($product->images); @endphp
            @isset($images[0])
                <img src="{{ asset($images[0]) }}" alt="{{ $product->name }}" />
            @endisset
        </a>
    </div>
    <div class="cards-md__info d-flex justify-content-between align-items-center">
        <a href="{{ route('front.productDetail', ['product' => $product->slug]) }}" class="cards-md__info-left">
            <h6 class="font-body--md-400">{{ Str::of($product->name)->limit(20) }}</h6>
            <div class="cards-md__info-price">
                <span class="font-body--lg-500">{{ getMoneyFormat($product->price) }} <span
                        class="font-body--md-500">TL</span></span>
            </div>
        </a>
        <div class="cards-md__info-right addToCartBtn" data-url="{{ route('front.addToCart') }}"
            data-p="{{ encrypt($product->id) }}">
            <span class="action-btn">
                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6.66667 8.83333H4.16667L2.5 18H17.5L15.8333 8.83333H13.3333M6.66667 8.83333V6.33333C6.66667 4.49239 8.15905 3 10 3V3C11.8409 3 13.3333 4.49238 13.3333 6.33333V8.83333M6.66667 8.83333H13.3333M6.66667 8.83333V11.3333M13.3333 8.83333V11.3333"
                        stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
        </div>
    </div>
</div>
