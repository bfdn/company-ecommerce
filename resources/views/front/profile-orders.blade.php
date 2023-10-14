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
                        <div class="dashboard__order-history" style="margin-top: 24px">
                            <div class="dashboard__order-history-title">
                                <h2 class="font-body--xxl-500">Siparişlerim</h2>
                            </div>
                            <div class="dashboard__order-history-table">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="dashboard__order-history-table-title">
                                                    Sipariş No
                                                </th>
                                                <th scope="col" class="dashboard__order-history-table-title">
                                                    Tarih
                                                </th>
                                                <th scope="col" class="dashboard__order-history-table-title">
                                                    Toplam Tutar
                                                </th>
                                                <th scope="col" class="dashboard__order-history-table-title">
                                                    Durum
                                                </th>
                                                <th scope="col" class="dashboard__order-history-table-title"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <!-- Order Id  -->
                                                    <td class="dashboard__order-history-table-item order-id">
                                                        #{{ $order->order_no }}
                                                    </td>
                                                    <!-- Date  -->
                                                    <td class="dashboard__order-history-table-item order-date">
                                                        {{ date('d-m-Y', strtotime($order->created_at)) }}
                                                    </td>
                                                    <!-- Total  -->
                                                    <td class="dashboard__order-history-table-item order-total">
                                                        <p class="order-total-price">
                                                            {{ getMoneyFormat($order->total_price + $order->tax_total_price) . ' TL' }}
                                                            <span class="quantity"> ({{ $order->total_qty }} Ürün)</span>
                                                        </p>
                                                    </td>
                                                    <!-- Status -->
                                                    <td class="dashboard__order-history-table-item order-status">
                                                        {{ $order->order_status->title() }}
                                                    </td>
                                                    <!-- Details page  -->
                                                    <td class="dashboard__order-history-table-item order-details">
                                                        <a
                                                            href="{{ route('front.profile.orders.detail', ['order' => $order->order_no]) }}">
                                                            Detaylar</a>
                                                    </td>
                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                </div>

                                <div class="dashboard__order-pagination">
                                    {{ $orders->onEachside(0)->links('front.paginate') }}
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
