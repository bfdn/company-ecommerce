@extends('layouts.admin')
@section('title')
    Kategori {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/choices.js/public/assets/styles/choices.css') }}">
@endsection
@section('js')
    <script src="{{ asset('assets/admin/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
@endsection
@push('style')
@endpush
@push('javascript')
    <script src="{{ asset('assets/admin/js/jquery-slugify/speakingurl.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery-slugify/slugify.min.js') }}"></script>
    <script>
        @foreach ($langs as $lang)
            $('.url_slug_{{ $lang->short_name }}').slugify('.title_slug_{{ $lang->short_name }}'); // Type as you slug
        @endforeach
    </script>
@endpush
@section('content')
    <x-elements.card>
        <x-slot:header>
            Kategori {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
            <a href="{{ route('admin.category.index') }}" class="btn btn-secondary float-end"><i class="bi bi-arrow-left"></i>
                Geri
                Dön</a>
        </x-slot:header>
        <x-slot:content>

            <form
                action="{{ isset($item) ? route('admin.category.update', ['category' => $item->id]) : route('admin.category.store') }}"
                id="Form">
                @csrf
                @method(isset($item) ? 'PUT' : 'POST')




                <div class="row">
                    <div class="col-12">
                        <div class="list-group list-group-horizontal-sm mb-1 text-center" role="tablist">
                            @foreach ($langs as $lang)
                                <a class="list-group-item list-group-item-action {{ $loop->first ? 'active' : '' }}"
                                    id="list-lang-list" data-bs-toggle="list" href="#list-{{ $lang->short_name }}"
                                    role="tab">{{ $lang->name }}</a>
                            @endforeach
                        </div>
                        <div class="tab-content text-justify">
                            @foreach ($langs as $lang)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="list-{{ $lang->short_name }}" role="tabpanel" aria-labelledby="list-lang-list">


                                    <div class="row">

                                        <div class="col-sm-6">
                                            <x-elements.input type="text" label="Kategori Adı"
                                                class="title_slug_{{ $lang->short_name }}" id="name"
                                                placeHolder="Kategori Adı" name="name[{{ $lang->short_name }}]"
                                                defaultValue="{{ isset($item) ? $item->getTranslation('name', $lang->short_name) : '' }}" />
                                        </div>

                                        <div class="col-sm-6">
                                            <x-elements.input type="text" label="Slug"
                                                class="url_slug_{{ $lang->short_name }}" id="slug" placeHolder="Slug"
                                                name="slug[{{ $lang->short_name }}]"
                                                defaultValue="{{ isset($item) ? $item->getTranslation('slug', $lang->short_name) : '' }}" />
                                        </div>

                                        <div class="col-sm-12">
                                            <x-elements.input type="text" label="Açıklama" id="content"
                                                placeHolder="Açıklama" name="content[{{ $lang->short_name }}]"
                                                defaultValue="{{ isset($item) ? $item->getTranslation('content', $lang->short_name) : '' }}" />
                                        </div>
                                        <div class="col-sm-12">
                                            <x-elements.input type="text" label="Seo Keywords" id="seo_keywords"
                                                placeHolder="Seo Keywords" name="seo_keywords[{{ $lang->short_name }}]"
                                                defaultValue="{{ isset($item) ? $item->getTranslation('seo_keywords', $lang->short_name) : '' }}" />
                                        </div>
                                        <div class="col-sm-12">
                                            <x-elements.input type="text" label="Seo Description" id="seo_description"
                                                placeHolder="Seo Description"
                                                name="seo_description[{{ $lang->short_name }}]"
                                                defaultValue="{{ isset($item) ? $item->getTranslation('seo_description', $lang->short_name) : '' }}" />
                                        </div>

                                    </div>

                                </div>
                            @endforeach
                        </div>



                        <div class="col-12">
                            <label for="parent_id">Üst Kategori</label>
                            <select class="choices" id="parent_category" name="parent_id">
                                <option value="">Seçiniz</option>

                                @foreach ($categories as $category)
                                    <x-elements.option :category="$category" categoryFullName="" name="parent_id"
                                        defaultValue="{{ $item->parent_id ?? '' }}" />
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <x-elements.select label="Durum" class="choices" id="status" name="status"
                                :status="$status" defaultValue="{{ $item->status ?? '' }}"></x-elements.select>
                        </div>



                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <x-elements.input type="file" label="Kategori Resmi" id="image" name="image" />
                                </div>
                                <div class="col-6">
                                    @isset($item->image)
                                        <img src="{{ asset($item->image) }}" width="100" />
                                    @endisset
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <x-elements.button :type="'submit'" :class="'btn btn-primary me-1 mb-1'" :id="'btnSave'" :buttonText="'Kaydet'" />
                            <x-elements.button :type="'reset'" :class="'btn btn-light-secondary me-1 mb-1'" :buttonText="'Temizle'" />
                        </div>
                    </div>

                </div>


            </form>

        </x-slot:content>
    </x-elements.card>
@endsection
