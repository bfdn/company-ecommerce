@extends('layouts.admin')
@section('title')
    Ürünler
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
            @can('Ürün Ekle')
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-between">
                        <div></div>
                        <a href="{{ route('admin.product.create') }}" class="btn btn-success"><i class="bi bi-plus"></i>
                            Ürün Ekle</a>
                    </div>
                </div>
            @endcan
        </x-slot:header>
        <x-slot:content>

            <x-elements.table id="dTable1" :class="'table-bordered table-striped'">
                <x-slot:columns>
                    <tr>
                        <th>Kategori</th>
                        <th>Ürün Adı</th>
                        <th>Fiyat</th>
                        <th>Vergi Oranı</th>
                        <th>Ekleyen Üye</th>
                        <th>Durum</th>
                        <th>Popüler</th>
                        <th>Kayıt Tarihi</th>
                        <th class="nosort">İşlem</th>
                    </tr>
                </x-slot:columns>
                <x-slot name="rows">
                    @foreach ($items as $item)
                        <tr>

                            <td>
                                @empty(!$item->categories->first()->ancestors)
                                    @foreach ($item->categories->first()->ancestors as $parentCategory)
                                        {{ $parentCategory->name . ' > ' }}
                                    @endforeach
                                @endempty
                                {{ $item->categories->first()->name ?? '' }}
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ getMoneyFormat($item->price) . ' ₺' }}</td>
                            <td>{{ '%' . $item->tax->value }}</td>
                            <td>{{ $item->user->name ?? '' }}</td>
                            <td>
                                @if (auth()->user()->can('Ürün Düzenle'))
                                    <x-elements.checkbox name="status" class="statusChange" :defaultValue="$item->status->value"
                                        dataUrl="{{ route('admin.product.statusChange', ['product' => $item->id]) }}"
                                        :formSwitch="true" />
                                @else
                                    @if ($item->status->value == 1)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Pasif</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if (auth()->user()->can('Ürün Düzenle'))
                                    <x-elements.checkbox name="popular" class="popularChange" :defaultValue="$item->popular->value"
                                        dataUrl="{{ route('admin.product.popularChange', ['product' => $item->id]) }}"
                                        :formSwitch="true" />
                                @else
                                    @if ($item->status->value == 1)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Pasif</span>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                @can('Ürün Düzenle')
                                    <a href="{{ route('admin.product.edit', ['product' => $item->id]) }}"
                                        class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                @endcan
                                @can('Ürün Sil')
                                    <x-elements.button type="button" class="btn btn-danger btn-sm btnDelete"
                                        dataUrl="{{ route('admin.product.destroy', ['product' => $item->id]) }}">
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
