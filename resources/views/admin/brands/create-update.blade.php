@extends('layouts.admin')
@section('title')
    Marka {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
@endsection
@section('css')
@endsection
@section('js')
@endsection
@push('style')
@endpush
@push('javascript')
    <script src="{{ asset('assets/admin/js/jquery-slugify/speakingurl.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery-slugify/slugify.min.js') }}"></script>
@endpush
@section('content')
    <x-elements.card>
        <x-slot:header>
            Marka {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
            <a href="{{ route('admin.brand.index') }}" class="btn btn-secondary float-end"><i class="bi bi-arrow-left"></i>
                Geri
                Dön</a>
        </x-slot:header>
        <x-slot:content>

            <form
                action="{{ isset($item) ? route('admin.brand.update', ['brand' => $item->id]) : route('admin.brand.store') }}"
                id="Form">
                @csrf
                @method(isset($item) ? 'PUT' : 'POST')
                <div class="row">
                    <div class="col-sm-6">
                        <x-elements.input type="text" label="Marka Adı" class="title_slug" id="name"
                            placeHolder="Marka Adı" name="name" defaultValue="{{ $item->name ?? '' }}" />
                    </div>

                    <div class="col-sm-6">
                        <x-elements.input type="text" label="Slug" class="url_slug" id="slug" placeHolder="Slug"
                            name="slug" defaultValue="{{ $item->slug ?? '' }}" />
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
