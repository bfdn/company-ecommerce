@extends('layouts.admin')
@section('title')
    Diller
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
            @can('Dil Ekle')
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-between">
                        <div></div>
                        <a href="{{ route('admin.language.create') }}" class="btn btn-success"><i class="bi bi-plus"></i>
                            Dil Ekle</a>
                    </div>
                </div>
            @endcan
        </x-slot:header>
        <x-slot:content>

            <x-elements.table id="dTable1" :class="'table-bordered table-striped'">
                <x-slot:columns>
                    <tr>
                        <th>Dil Adı</th>
                        <th>Ekleyen Üye</th>
                        <th>Kısa Kodu</th>
                        <th>Açıklama</th>
                        <th>Durum</th>
                        <th>Kayıt Tarihi</th>
                        <th class="nosort">İşlem</th>
                    </tr>
                </x-slot:columns>
                <x-slot name="rows">
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->user->name ?? '' }}</td>
                            <td>{{ $item->short_name }}</td>

                            <td>{{ $item->description }}</td>
                            <td>
                                @if (auth()->user()->can('Dil Sil'))
                                    <x-elements.checkbox name="status" class="statusChange" :defaultValue="$item->status"
                                        dataUrl="{{ route('admin.language.statusChange', ['language' => $item->id]) }}"
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
                                @can('Dil Düzenle')
                                    <a href="{{ route('admin.language.edit', ['language' => $item->id]) }}"
                                        class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                @endcan
                                @can('Dil Sil')
                                    <x-elements.button type="button" class="btn btn-danger btn-sm btnDelete"
                                        dataUrl="{{ route('admin.language.destroy', ['language' => $item->id]) }}">
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
