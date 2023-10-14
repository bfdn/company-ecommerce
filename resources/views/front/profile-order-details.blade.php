@extends('layouts.front')
@section('title')
    {{ $page_title }}
@endsection

@section('meta')
    <meta name="description" content="{{ isset($item) ? $item->seo_description : '' }}">
    <meta name="keywords" content="{{ isset($item) ? $item->seo_keywords : '' }}">
@endsection
@section('css')
@endsection
@push('style')
@endpush




@section('content')
    <x-front.breadcrumb :breadcrumbs="$breadcrumbs ?? ''" />


    <!-- dashboard Secton Start  -->
    <div class="dashboard section">
        <div class="container">
            <div class="row dashboard__content">
                <div class="col-lg-3">
                    @include('front.profile-menu')
                </div>
                <div class="col-lg-9 section--xl pt-0">
                    <div class="container">
                        <!-- Order History  -->
                        <div class="dashboard__order-history">
                            <div class="dashboard__order-history-title">
                                <h2 class="font-body--xxl-500">Sipariş Detayları</h2>
                                <a href="{{ route('front.profile.orders') }}">Geri Dön</a>
                            </div>

                            <div class="dashboard__details-content">
                                <div class="row">
                                    <div class="col-xl-8">
                                        <div class="dashboard__details-card">
                                            <div class="dashboard__details-card-item">
                                                <h5 class="dashboard__details-card-title">
                                                    Fatura Addresi
                                                </h5>
                                                <!-- billing Address -->
                                                <div class="dashboard__details-card-item__inner">
                                                    <h2 class="font-body--lg-400 name">
                                                        {{ $order->name . ' ' . $order->surname }}
                                                    </h2>
                                                    <p class="font-body--md-400">
                                                        {{ $order->address }}
                                                    </p>
                                                </div>
                                                <div class="dashboard__details-card-item__inner">
                                                    <div
                                                        class="
                                  dashboard__details-card-item__inner-contact
                                ">
                                                        <h5 class="title">Email</h5>
                                                        <p class="font-body--md-400">
                                                            {{ $order->email }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="
                                  dashboard__details-card-item__inner-contact
                                ">
                                                        <h5 class="title">Telefon</h5>
                                                        <p class="font-body--md-400">{{ $order->phone }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dashboard__details-card-item">
                                                <h5 class="dashboard__details-card-title">
                                                    Kategori Addresi
                                                </h5>
                                                <!-- Shipping Address -->
                                                <div class="dashboard__details-card-item__inner">
                                                    <h2 class="font-body--lg-400 name">
                                                        {{ $order->name . ' ' . $order->surname }}
                                                    </h2>
                                                    <p class="font-body--md-400">
                                                        {{ $order->address }}
                                                    </p>
                                                </div>
                                                <div class="dashboard__details-card-item__inner">
                                                    <div
                                                        class="
                                  dashboard__details-card-item__inner-contact
                                ">
                                                        <h5 class="title">Email</h5>
                                                        <p class="font-body--md-400">
                                                            {{ $order->email }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="
                                  dashboard__details-card-item__inner-contact
                                ">
                                                        <h5 class="title">Telefon</h5>
                                                        <p class="font-body--md-400">{{ $order->phone }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="dashboard__totalpayment-card">
                                            <div class="dashboard__totalpayment-card-header">
                                                <div class="dashboard__totalpayment-card-header-item">
                                                    <h5 class="title">Sipariş No:</h5>
                                                    <p class="details order-id">#{{ $order->order_no }}</p>
                                                </div>
                                                <div class="dashboard__totalpayment-card-header-item">
                                                    <h5 class="title">Ödeme Metodu:</h5>
                                                    <p class="details order-id">{{ $order->payment_method->title() }}</p>
                                                </div>
                                            </div>

                                            <div class="dashboard__totalpayment-card-body">
                                                <div class="dashboard__totalpayment-card-body-item">
                                                    <h5 class="font-body--md-400">Ara Toplam:</h5>
                                                    <p class="font-body--md-500">
                                                        {{ getMoneyFormat($order->total_price) . ' TL' }}</p>
                                                </div>
                                                <div class="dashboard__totalpayment-card-body-item">
                                                    <h5 class="font-body--md-400">Vergi Tutarı:</h5>
                                                    <p class="font-body--md-500">
                                                        {{ getMoneyFormat($order->tax_total_price) . ' TL' }}</p>
                                                </div>

                                                <div class="dashboard__totalpayment-card-body-item total">
                                                    <h5 class="font-body--xl-400">Toplam Tutar:</h5>
                                                    <p class="font-body--xl-500">
                                                        {{ getMoneyFormat($order->total_price + $order->tax_total_price) . ' TL' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="progress__bar progress__bar-1x">
                                <div class="progress__bar-border">
                                    <span class="progress__bar-border-active"></span>
                                </div>
                                <div class="progress__bar-item active">
                                    <div class="progress__bar-item-ball">
                                        <p class="font-body--md-400 count-number count-number-active">
                                            01
                                        </p>
                                        <span class="check-mark">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16.6663 5.83301L7.49967 14.9997L3.33301 10.833"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                    <h2 class="font-body--md-400">Order received</h2>
                                </div>
                                <div class="progress__bar-item">
                                    <div class="progress__bar-item-ball">
                                        <p class="font-body--md-400 count-number">02</p>
                                    </div>
                                    <h2 class="font-body--md-400">Processing</h2>
                                </div>
                                <div class="progress__bar-item">
                                    <div class="progress__bar-item-ball">
                                        <p class="font-body--md-400 count-number">03</p>
                                    </div>
                                    <h2 class="font-body--md-400">one the way</h2>
                                </div>
                                <div class="progress__bar-item">
                                    <div class="progress__bar-item-ball">
                                        <p class="font-body--md-400 count-number">04</p>
                                    </div>
                                    <h2 class="font-body--md-400">Delivered</h2>
                                </div>
                            </div>

                            <div class="dashboard__order-history-table dashboard__order-history-table__product-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="dashboard__order-history-table-title">
                                                    Ürün Adı
                                                </th>
                                                <th scope="col" class="dashboard__order-history-table-title">
                                                    Fiyat
                                                </th>
                                                <th scope="col" class="dashboard__order-history-table-title">
                                                    Adet
                                                </th>

                                                <th scope="col" class="dashboard__order-history-table-title">
                                                    Vergi Oranı / Tutarı
                                                </th>

                                                <th scope="col" class="dashboard__order-history-table-title">
                                                    Toplam Tutar
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order_details as $order_detail)
                                                <tr>
                                                    <!-- Product item  -->
                                                    <td class="dashboard__order-history-table-item align-middle">
                                                        <a href="{{ route('front.productDetail', ['product' => $order_detail->product->slug]) }}"
                                                            class="dashboard__product-item">
                                                            <div class="dashboard__product-item-img">
                                                                @php $image = json_decode($order_detail->product->images)[0]??''; @endphp
                                                                @if ($image)
                                                                    <img src="{{ asset($image) }}"
                                                                        alt="{{ $order_detail->product->name }}" />
                                                                @endif

                                                            </div>
                                                            <h5 class="font-body--md-400">
                                                                {{ Str::of($order_detail->product->name)->limit(20) }}</h5>
                                                        </a>
                                                    </td>
                                                    <!-- Price  -->
                                                    <td
                                                        class="dashboard__order-history-table-item order-date align-middle">
                                                        {{ getMoneyFormat($order_detail->price) . ' TL' }}
                                                    </td>
                                                    <!-- quantity -->
                                                    <td
                                                        class="dashboard__order-history-table-item order-total align-middle">
                                                        <p class="order-total-price">x{{ $order_detail->qty }}</p>
                                                    </td>
                                                    <!-- Subtotal  -->
                                                    <td
                                                        class="dashboard__order-history-table-item order-status align-middle text-start">
                                                        <p class="font-body--md-500">
                                                            {{ '%' . $order_detail->tax->value . ' / ' . getMoneyFormat($order_detail->tax_price) . ' TL' }}
                                                        </p>
                                                    </td>
                                                    <!-- Total  -->
                                                    <td
                                                        class="dashboard__order-history-table-item order-status align-middle text-start">
                                                        <p class="font-body--md-500">
                                                            {{ getMoneyFormat($order_detail->total_price) . ' TL' }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- dashboard Secton  End  -->
@endsection




@section('js')
@endsection
@push('javascript')
    <script src="{{ asset('assets/front/lib/js/nouislider.min.js') }}"></script>
@endpush
