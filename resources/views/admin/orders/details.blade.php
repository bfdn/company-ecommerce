@extends('layouts.admin')
@section('title')
    {{ $order->order_no . ' nolu sipariş' }}
@endsection
@section('css')
    <style>
        .bg-black-opacity {
            background: rgba(0, 0, 0, .1);
        }

        .zindex-999 {
            z-index: 999;
        }
    </style>
@endsection
@section('js')
@endsection
@push('style')
@endpush
@push('javascript')
@endpush
@section('content')
    <div
        class="load-spin d-none justify-content-center align-items-center position-absolute top-0 start-0 vw-100 vh-100 bg-black-opacity zindex-999">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <x-elements.card>
        <x-slot:header>
            @can('Sipariş Listele')
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-between">
                        <div>Siparişteki Ürünler</div>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i>
                            Geri Dön</a>
                    </div>
                </div>
            @endcan
        </x-slot:header>
        <x-slot:content>

            <x-elements.table id="dTable1" :class="'table-bordered table-striped'">
                <x-slot:columns>
                    <tr>
                        <th>Ürün</th>
                        <th>Fiyat</th>
                        <th>Adet</th>
                        <th>KDV Oranı - Fiyat</th>
                        <th>Toplam Tutar</th>
                    </tr>
                </x-slot:columns>
                <x-slot name="rows">
                    @foreach ($order_details as $order_detail)
                        <tr>
                            <td>{{ $order_detail->product->name }}</td>
                            <td>{{ $order_detail->price }}</td>
                            <td>{{ $order_detail->qty }}</td>
                            <td>{{ '%' . $order_detail->tax->value . ' => ' . getMoneyFormat($order_detail->tax_price) . ' TL' }}
                            </td>
                            <td>{{ getMoneyFormat($order_detail->total_price) . ' TL' }}</td>

                        </tr>
                    @endforeach


                </x-slot>
            </x-elements.table>
        </x-slot:content>
    </x-elements.card>

    <div class="row">
        <div class="col-sm-6">
            <x-elements.card>
                <x-slot:header>
                    {{ $order_user->name . ' kullanıcının ' . $order->order_no . " no'lu siparişi" }}
                </x-slot:header>
                <x-slot:content>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Sipariş Veren</span>
                            <span class="badge badge-pill ml-1 text-black">{{ $order_user->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Sipariş No</span>
                            <span class="badge badge-pill ml-1 text-black">{{ $order->order_no }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Ödeme Metodu</span>
                            <span class="badge badge-pill ml-1 text-black">{{ $order->payment_method->title() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Durum</span>
                            <span class="badge badge-pill ml-1 text-black">

                                <x-elements.select label="" class="order-status"
                                    dataUrl="{{ route('admin.orders.statusChange', ['order' => $order->id]) }}"
                                    id="status" name="order_status" :status="$order_status"
                                    defaultValue="{{ $order->order_status->value ?? '' }}"></x-elements.select>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Tutar</span>
                            <span
                                class="badge badge-pill ml-1 text-black">{{ getMoneyFormat($order->total_price) . ' TL' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Adet</span>
                            <span class="badge badge-pill ml-1 text-black">{{ $order->total_qty }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Vergi Tutarı</span>
                            <span
                                class="badge badge-pill ml-1 text-black">{{ getMoneyFormat($order->tax_total_price) . ' TL' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Toplam Tutar</span>
                            <span
                                class="badge badge-pill ml-1 text-black">{{ getMoneyFormat($order->total_price + $order->tax_total_price) . ' TL' }}</span>
                        </li>



                    </ul>
                </x-slot:content>
            </x-elements.card>
        </div>
        <div class="col-sm-6">
            <x-elements.card>
                <x-slot:header>
                    Fatura ve Adres Bilgileri
                </x-slot:header>
                <x-slot:content>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Ad Soyad</span>
                            <span class="badge badge-pill ml-1 text-black">{{ $order_user->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Firma </span>
                            <span class="badge badge-pill ml-1 text-black">{{ $order->company }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Adres </span>
                            <span class="badge badge-pill ml-1 text-black">{{ $order->address }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Email</span>
                            <span class="badge badge-pill ml-1 text-black">{{ $order->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Telefon</span>
                            <span class="badge badge-pill ml-1 text-black">{{ $order->phone }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Sipariş Notları</span>
                            <span class="badge badge-pill ml-1 text-black">{{ $order->notes }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span> Fatura ve Teslim Adresi aynı mı?</span>
                            <span class="badge badge-pill ml-1 text-black">{{ $order->same_address->title() }}</span>
                        </li>



                    </ul>
                </x-slot:content>
            </x-elements.card>
        </div>
    </div>
@endsection
