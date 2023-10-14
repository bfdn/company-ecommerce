@extends('layouts.admin')
@section('title')
    Kullanıcılar
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
            @can('Kullanıcı Ekle')
                <div class="row">
                    <div class="col-sm-6">Kullanıcılar</div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.user.create') }}" class="btn btn-success float-end"><i class="bi bi-plus"></i>
                            Kullanıcı
                            Ekle</a>
                    </div>
                </div>
            @endcan
            <form action="{{ route('admin.user.index') }}" method="get">
                <div class="row">
                    <div class="col-3">
                        <x-elements.input type="text" name="q" placeHolder="Ad Soyad veya Email"
                            label="Aranacak Kelime" defaultValue="{{ request()->get('q') }}" />
                    </div>
                    <div class="col-3">
                        <x-elements.select label="Durum" id="status" name="status" :status="$status"
                            defaultValue="{{ request()->get('status') }}" />
                    </div>
                    <div class="col-3">
                        <x-elements.input type="date" label="Kayıt tarihi" name="date"
                            defaultValue="{{ request()->get('date') }}" />
                    </div>
                    <div class="col-3 pt-4">
                        <x-elements.button type="submit" buttonText="Filtrele" class="btn btn-primary" />
                    </div>
                </div>
            </form>
        </x-slot:header>
        <x-slot:content>
            <x-elements.table :id="''" :class="'table-bordered table-striped'">
                <x-slot:columns>
                    <tr>
                        <th>Ad Soyad</th>
                        <th>Email</th>
                        <th>Rolü</th>
                        <th>Durum</th>
                        <th>Kayıt Tarihi</th>
                        <th>İşlem</th>
                    </tr>
                </x-slot:columns>
                <x-slot name="rows">
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->roles->first()->name ?? '' }}</td>
                            <td>
                                @if (auth()->user()->can('Yazı Düzenle'))
                                    <x-elements.checkbox name="status" class="statusChange" :defaultValue="$item->status"
                                        dataUrl="{{ route('admin.user.statusChange', ['user' => $item->id]) }}"
                                        :formSwitch="true" />
                                @else
                                    @if ($item->status == 1)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Pasif</span>
                                    @endif
                                @endif
                            </td>
                            <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                            <td>
                                @can('Kullanıcı Düzenle')
                                    <a href="{{ route('admin.user.edit', ['user' => $item->id]) }}"
                                        class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                @endcan

                                @can('Kullanıcı Sil')
                                    <x-elements.button type="button" class="btn btn-danger btn-sm btnDelete"
                                        dataUrl="{{ route('admin.user.destroy', ['user' => $item->id]) }}">
                                        <x-slot:buttonText><i class="bi bi-trash"></i></x-slot:buttonText>
                                    </x-elements.button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach


                </x-slot>
            </x-elements.table>


            {{ $items->appends(request()->all())->onEachside(0)->links() }}
        </x-slot:content>
    </x-elements.card>
@endsection
