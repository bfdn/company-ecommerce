@extends('layouts.admin')
@section('title')
    Kullanıcı {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
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
            Kullanıcı {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary float-end"><i class="bi bi-arrow-left"></i> Geri
                Dön</a>
        </x-slot:header>
        <x-slot:content>


            <form action="{{ isset($item) ? route('admin.user.update', ['user' => $item->id]) : route('admin.user.store') }}"
                id="Form">
                @csrf
                @method(isset($item) ? 'PUT' : 'POST')
                <div class="row">
                    <div class="col-sm-6">
                        <x-elements.input type="text" label="Ad Soyad" id="name" placeHolder="Ad Soyad" name="name"
                            defaultValue="{{ $item->name ?? '' }}" />
                    </div>
                    <div class="col-sm-6">
                        <x-elements.input type="email" label="Email Adresiniz" id="email"
                            placeHolder="Email Adresiniz" name="email" defaultValue="{{ $item->email ?? '' }}" />
                    </div>
                    <div class="col-sm-6">
                        <x-elements.input type="password" label="Parola" id="password" placeHolder="Parola" name="password"
                            defaultValue="" />
                    </div>

                    <div class="col-sm-6">
                        <x-elements.input type="password" label="Parola Tekrar" id="password_re" placeHolder="Parola Tekrar"
                            name="password_re" defaultValue="" />
                    </div>

                    <div class="col-12">
                        <x-elements.select :label="'Yetki Rolü'" :class="'choices'" :id="'role'" :name="'role'"
                            :options="$roles" :defaultValue="$user_role->id ?? ''"></x-elements.select>
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
