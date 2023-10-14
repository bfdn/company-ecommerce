@extends('layouts.admin')
@section('title')
    Roller
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
            @can('Rol Ekle')
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-between">
                        <div></div>
                        <a href="{{ route('admin.role.create') }}" class="btn btn-success"><i class="bi bi-plus"></i>
                            Rol
                            Ekle</a>
                    </div>
                </div>
            @endcan
            <div class="row">
                <div class="col-12">
                    <input type="text" id="search" class="form-control" placeholder="Ara">
                </div>
            </div>


        </x-slot:header>
        <x-slot:content>

            <x-elements.table id="dTable" :class="'table-bordered table-striped'" dataUrl="{{ route('admin.ajax.getRoles') }}">
                <x-slot:columns>
                    <tr>
                        <th data-data="name">Rol Adı</th>
                        <th data-data="created_at">Kayıt Tarihi</th>
                        <th class="nosort" data-data="button">İşlem</th>
                    </tr>
                </x-slot:columns>
                <x-slot name="rows">



                </x-slot>
            </x-elements.table>


        </x-slot:content>
    </x-elements.card>
@endsection
