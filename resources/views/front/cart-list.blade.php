@extends('layouts.front')
@section('title')
    {{ $page_title }}
@endsection

@section('meta')
    <meta name="description" content="Sepet">
    <meta name="keywords" content="Sepet">
@endsection
@section('css')
@endsection
@push('style')
@endpush




@section('content')
    <x-front.breadcrumb :breadcrumbs="$breadcrumbs ?? ''" />


    <!-- Shopping Cart Section Start   -->
    <section class="shoping-cart section section--xl">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('layouts.partials.errors')
                    @include('layouts.partials.alert')
                </div>
            </div>
            <div class="section__head justify-content-center">
                <h2 class="section--title-four font-title--sm">{{ __('front.cart') }}</h2>
            </div>
            <div class="row shoping-cart__content">
                @if (isset($products) && !empty($products))
                    <div class="col-lg-8">

                        <div class="cart-table">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="cart-table-title">{{ __('front.product') }}</th>
                                            </th>
                                            <th scope="col" class="cart-table-title">{{ __('front.price') }}</th>
                                            <th scope="col" class="cart-table-title">{{ __('front.quantity') }}</th>
                                            <th scope="col" class="cart-table-title">KDV</th>
                                            <th scope="col" class="cart-table-title">{{ __('front.subtotal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($products as $product)
                                            <tr>
                                                <!-- Product item  -->
                                                <td class="cart-table-item align-middle">
                                                    <a href="{{ route('front.productDetail', ['product' => $product->slug]) }}"
                                                        class="cart-table__product-item">
                                                        <div class="cart-table__product-item-img">
                                                            @php
                                                            $image = json_decode($product->images)[0]; @endphp
                                                            <img src="{{ asset($image) }}" alt="{{ $product->name }}" />
                                                        </div>
                                                        <h5 class="font-body--lg-400">
                                                            {{ Str::of($product->name)->limit(20) }}</h5>
                                                    </a>
                                                </td>
                                                <!-- Price  -->
                                                <td class="cart-table-item order-date align-middle">
                                                    {{ getMoneyFormat($product->price) . ' TL' }}
                                                </td>
                                                <!-- quantity -->
                                                <td class="cart-table-item order-total align-middle">
                                                    <div class="counter-btn-wrapper">
                                                        <button class="counter-btn-dec counter-btn"
                                                            onclick="decrement(this)"
                                                            data-url="{{ route('front.cart.decCount') }}"
                                                            data-p="{{ encrypt($product->id) }}">
                                                            -
                                                        </button>
                                                        <input type="number" id="counter-btn-counter"
                                                            class="counter-btn-counter" min="0" max="1000"
                                                            placeholder="1" value="{{ $product->qty }}" />
                                                        <button class="counter-btn-inc counter-btn"
                                                            onclick="increment(this)"
                                                            data-url="{{ route('front.cart.incCount') }}"
                                                            data-p="{{ encrypt($product->id) }}">
                                                            +
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="cart-table-item order-date align-middle">
                                                    ({{ '%' . $product->tax->value }})
                                                    <span>{{ getMoneyFormat($product->tax_price) }}</span>
                                                </td>
                                                <!-- Subtotal  -->
                                                <td class="cart-table-item order-subtotal align-middle">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="font-body--md-500">
                                                            {{ getMoneyFormat($product->total_price + $product->tax_price) . ' TL' }}
                                                        </p>
                                                        <button class="delete-item"
                                                            data-url="{{ route('front.cart.removeFromCart') }}"
                                                            data-p="{{ encrypt($product->id) }}">
                                                            <svg width="24" height="25" viewBox="0 0 24 25"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M12 23.5C18.0748 23.5 23 18.5748 23 12.5C23 6.42525 18.0748 1.5 12 1.5C5.92525 1.5 1 6.42525 1 12.5C1 18.5748 5.92525 23.5 12 23.5Z"
                                                                    stroke="#CCCCCC" stroke-miterlimit="10" />
                                                                <path d="M16 8.5L8 16.5" stroke="#666666" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M16 16.5L8 8.5" stroke="#666666" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- Action Buttons  -->
                            {{-- <form action="#"> --}}
                            <div class="cart-table-action-btn d-flex">
                                <a href="{{ route('front.index') }}" class="button button--md shop">Alışverişe
                                    Dön</a>
                                {{-- <a href="#" class="button button--md button--disable update">Sepet Güncelle</a> --}}
                            </div>
                            {{-- </form> --}}
                        </div>


                        <div class="shoping-cart__mobile">
                            @foreach ($products as $product)
                                <div class="shoping-card">
                                    <div class="shoping-card__img-wrapper">
                                        @php
                                        $image = json_decode($product->images)[0]; @endphp
                                        <img src="{{ asset($image) }}" alt="{{ $product->name }}" />
                                    </div>
                                    <h5 class="shoping-card__product-caption font-body--lg-400">
                                        {{ Str::of($product->name)->limit(20) }}
                                    </h5>

                                    <h6 class="shoping-card__product-price font-body--lg-400">
                                        {{ getMoneyFormat($product->price) . ' TL' }}
                                    </h6>
                                    <div>
                                        KDV:
                                        ({{ '%' . $product->tax->value }})
                                        <span>{{ getMoneyFormat($product->tax_price) . ' TL' }}</span>
                                    </div>
                                    <div class="counter-btn-wrapper">
                                        <button class="counter-btn-dec counter-btn" onclick="decrement(this)"
                                            data-url="{{ route('front.cart.decCount') }}"
                                            data-p="{{ encrypt($product->id) }}">
                                            -
                                        </button>
                                        <input type="number" id="counter-btn-counter" class="counter-btn-counter"
                                            min="0" max="1000" placeholder="1" value="{{ $product->qty }}" />
                                        <button class="counter-btn-inc counter-btn" onclick="increment(this)"
                                            data-url="{{ route('front.cart.incCount') }}"
                                            data-p="{{ encrypt($product->id) }}">
                                            +
                                        </button>
                                    </div>
                                    <h6 class="shoping-card__product-totalprice font-body--lg-600">
                                        {{ getMoneyFormat($product->total_price + $product->tax_price) . ' TL' }}
                                    </h6>
                                    <button class="close-btn delete-item"
                                        data-url="{{ route('front.cart.removeFromCart') }}"
                                        data-p="{{ encrypt($product->id) }}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 23C18.0748 23 23 18.0748 23 12C23 5.92525 18.0748 1 12 1C5.92525 1 1 5.92525 1 12C1 18.0748 5.92525 23 12 23Z"
                                                stroke="#CCCCCC" stroke-miterlimit="10" />
                                            <path d="M16 8L8 16" stroke="#666666" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M16 16L8 8" stroke="#666666" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>


                        {{-- <form action="#"> --}}
                        <div class="cart-table-action-btn d-none">
                            <a href="{{ route('front.index') }}" class="button button--md shop">Alışverişe
                                Dön</a>
                            {{-- <a href="#" class="button button--md button--disable update">Sepet Güncelle</a> --}}
                        </div>
                        {{-- </form> --}}
                    </div>








                    <div class="col-lg-4">
                        <div class="bill-card">
                            <div class="bill-card__content">
                                <div class="bill-card__header">
                                    <h2 class="bill-card__header-title font-body--xxl-500">
                                        Sipariş Özeti
                                    </h2>
                                </div>
                                <div class="bill-card__body">
                                    <!-- memo  -->
                                    <div class="bill-card__memo">
                                        <!-- Subtotal  -->
                                        <div class="bill-card__memo-item subtotal">
                                            <p class="font-body--md-400">Ara Toplam:</p>
                                            <span
                                                class="font-body--md-500">{{ getMoneyFormat($summary->total_price ?? 0) . ' TL' }}</span>
                                        </div>
                                        <!-- Shipping  -->
                                        <div class="bill-card__memo-item shipping">
                                            <p class="font-body--md-400">KDV:</p>
                                            <span class="font-body--md-500">
                                                {{ getMoneyFormat($summary->tax_total_price ?? 0) . ' TL' }}
                                            </span>
                                        </div>
                                        <!-- total  -->
                                        <div class="bill-card__memo-item total">
                                            <p class="font-body--lg-400">Total:</p>
                                            <span
                                                class="font-body--xl-500">{{ getMoneyFormat(($summary->total_price ?? 0) + ($summary->tax_total_price ?? 0)) . ' TL' }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('front.cartInfo') }}" class="button button--lg w-100"
                                        style="margin-top: 20px" type="submit">
                                        Sipariş Ver
                                    </a>
                                    {{-- <form action="#">
                                        <button class="button button--lg w-100" style="margin-top: 20px" type="submit">
                                            Sipariş Ver
                                        </button>
                                    </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12">
                        <div class="alert alert-warning" role="alert">
                            Sepetinizde herhangi bir <strong>ürün bulunmamaktadır</strong> <a
                                href="{{ route('front.index') }}">Alışverişe devam et</a>
                        </div>
                    </div>
                @endif



            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End    -->
@endsection




@section('js')
@endsection
@push('javascript')
@endpush
