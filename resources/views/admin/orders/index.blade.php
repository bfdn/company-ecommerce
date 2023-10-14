@extends('layouts.admin')
@section('title')
    Siparişler
@endsection
@section('css')
@endsection
@section('js')
@endsection
@push('style')
@endpush
@push('javascript')
@endpush
@section('content')
    <x-elements.card>
        <x-slot:header>
            @can('Sipariş Ekle')
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-between">
                        <div></div>

                    </div>
                </div>
            @endcan
        </x-slot:header>
        <x-slot:content>

            <x-elements.table id="dTable1" :class="'table-bordered table-striped'">
                <x-slot:columns>
                    <tr>
                        <th>Sipariş No</th>
                        <th>Sipariş Veren</th>
                        <th>Ödeme Metodu</th>
                        <th>Adet</th>
                        <th>Toplam Tutar</th>
                        <th>Durum</th>
                        <th>Sipariş Tarihi</th>
                        <th class="nosort">İşlem</th>
                    </tr>
                </x-slot:columns>
                <x-slot name="rows">
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->order_no }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->payment_method->title() }}</td>
                            <td>{{ $item->total_qty }}</td>
                            <td>{{ getMoneyFormat($item->total_price + $item->tax_total_price) . ' TL' }}</td>
                            <td>{{ $item->order_status->title() }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                @can('Sipariş Listele')
                                    <a href="{{ route('admin.orders.show', ['order' => $item->id]) }}"
                                        class="btn btn-success btn-sm"><i class="bi bi-eye"></i></a>
                                @endcan

                                @can('Sipariş Sil')
                                    <x-elements.button type="button" class="btn btn-danger btn-sm btnDelete"
                                        dataUrl="{{ route('admin.orders.destroy', ['order' => $item->id]) }}">
                                        <x-slot:buttonText><i class="bi bi-trash"></i></x-slot:buttonText>
                                    </x-elements.button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach


                </x-slot>
            </x-elements.table>
        </x-slot:content>
    </x-elements.card>
@endsection
