@extends('layouts.admin')
@section('title')
    Markalar
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
            @can('Marka Ekle')
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-between">
                        <div></div>
                        <a href="{{ route('admin.brand.create') }}" class="btn btn-success"><i class="bi bi-plus"></i>
                            Marka Ekle</a>
                    </div>
                </div>
            @endcan
        </x-slot:header>
        <x-slot:content>

            <x-elements.table id="dTable1" :class="'table-bordered table-striped'">
                <x-slot:columns>
                    <tr>
                        <th>Marka Adı</th>
                        <th>Slug</th>
                        <th>Ekleyen Üye</th>
                        <th>Durum</th>
                        <th>Kayıt Tarihi</th>
                        <th class="nosort">İşlem</th>
                    </tr>
                </x-slot:columns>
                <x-slot name="rows">
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>
                                @if (auth()->user()->can('Marka Düzenle'))
                                    <x-elements.checkbox name="status" class="statusChange" :defaultValue="$item->status"
                                        dataUrl="{{ route('admin.brand.statusChange', ['brand' => $item->id]) }}"
                                        :formSwitch="true" />
                                @else
                                    @if ($item->status == 1)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Pasif</span>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                @can('Marka Düzenle')
                                    <a href="{{ route('admin.brand.edit', ['brand' => $item->id]) }}"
                                        class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                @endcan
                                @can('Marka Sil')
                                    <x-elements.button type="button" class="btn btn-danger btn-sm btnDelete"
                                        dataUrl="{{ route('admin.brand.destroy', ['brand' => $item->id]) }}">
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
