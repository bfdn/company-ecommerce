@extends('layouts.admin')
@section('title')
    İzin {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
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
            İzin {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
            <a href="{{ route('admin.permission.index') }}" class="btn btn-secondary float-end"><i
                    class="bi bi-arrow-left"></i> Geri
                Dön</a>
        </x-slot:header>
        <x-slot:content>

            <form
                action="{{ isset($item) ? route('admin.permission.update', ['permission' => $item->id]) : route('admin.permission.store') }}"
                id="Form">
                @csrf
                @method(isset($item) ? 'PUT' : 'POST')
                <div class="row">
                    <div class="col-sm-12">
                        <x-elements.input type="text" label="İzin Adı" id="name" placeHolder="İzin Adı" name="name"
                            defaultValue="{{ $item->name ?? '' }}" />
                    </div>



                    <div class="col-12 d-flex justify-content-end">
                        <x-elements.button :type="'submit'" :class="'btn btn-primary me-1 mb-1'" :id="'btnSave'" :buttonText="'Kaydet'" />
                        <x-elements.button :type="'reset'" :class="'btn btn-light-secondary me-1 mb-1'" :buttonText="'Temizle'" />
                    </div>

                </div>
            </form>

        </x-slot:content>
    </x-elements.card>
@endsection
