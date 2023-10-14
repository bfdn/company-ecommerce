@extends('layouts.admin')
@section('title')
    Ürün {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/choices.js/public/assets/styles/choices.css') }}">
@endsection
@section('js')
    <script src="{{ asset('assets/admin/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/admin/js/parts/jquery.mask.js') }}"></script>
@endsection
@push('style')
@endpush
@push('javascript')
    <script src="{{ asset('assets/admin/js/jquery-slugify/speakingurl.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery-slugify/slugify.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/admin/filemanager?type=Images',
            filebrowserImageUploadUrl: '/admin/filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/admin/filemanager?type=Files',
            filebrowserUploadUrl: '/admin/filemanager/upload?type=Files&_token=',
            allowedContent: true,
        };
        @foreach ($langs as $lang)
            $('.url_slug_{{ $lang->short_name }}').slugify('.title_slug_{{ $lang->short_name }}'); // Type as you slug
            CKEDITOR.replace('ckeditor_{{ $lang->short_name }}', options);
        @endforeach

        $(document).ready(function() {
            // $(".inp").inputmask("xx-xxxxxxxx");
            // Inputmask("9{1,5}-9{1,5}").mask(".inp");
            // $('.inp').mask('099.99');
            $('.price').mask('000.000.000.000.000,00', {
                reverse: true
            });
            // $('.inp').mask("#.##0,00", {
            //     reverse: true
            // });
        });
    </script>
@endpush
@section('content')
    <x-elements.card>
        <x-slot:header>
            Ürün {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary float-end"><i class="bi bi-arrow-left"></i>
                Geri
                Dön</a>
        </x-slot:header>
        <x-slot:content>

            <form
                action="{{ isset($item) ? route('admin.product.update', ['product' => $item->id]) : route('admin.product.store') }}"
                id="Form" data-editor="true" enctype="multipart/form-data">
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
                                            <x-elements.input type="text" label="Ürün Adı"
                                                class="title_slug_{{ $lang->short_name }}" id="name"
                                                placeHolder="Ürün Adı" name="name[{{ $lang->short_name }}]"
                                                defaultValue="{{ isset($item) ? $item->getTranslation('name', $lang->short_name) : '' }}" />
                                        </div>

                                        <div class="col-sm-6">
                                            <x-elements.input type="text" label="Slug"
                                                class="url_slug_{{ $lang->short_name }}" id="slug" placeHolder="Slug"
                                                name="slug[{{ $lang->short_name }}]"
                                                defaultValue="{{ isset($item) ? $item->getTranslation('slug', $lang->short_name) : '' }}" />
                                        </div>

                                        <div class="col-sm-12">
                                            <x-elements.textarea label="Açıklama" id="ckeditor_{{ $lang->short_name }}"
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


                        <div class="row">

                            <div class="col-12">
                                <x-elements.select label="Marka" :class="'choices'" id="brand" name="brand_id"
                                    :options="$brands" :defaultValue="$item->brand_id ?? ''"></x-elements.select>
                            </div>


                            <div class="col-12">
                                <label for="category">Kategori</label>
                                <select class="choices" id="category" name="category_id[]" multiple="multiple">
                                    <option value="">Seçiniz</option>
                                    @foreach ($categories as $category)
                                        <x-elements.option :category="$category" categoryFullName="" name="category_id[]"
                                            :defaultValue="$selected_categories ?? ''" />
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-12">
                                <x-elements.select label="Durum" class="choices" id="status" name="status"
                                    :status="$status" defaultValue="{{ $item->status ?? '' }}"></x-elements.select>
                            </div>
                            <div class="col-sm-6">
                                <x-elements.input type="text" label="Fiyat" id="price" class="price"
                                    placeHolder="Fiyat" name="price"
                                    defaultValue="{{ isset($item->price) ? getMoneyFormat($item->price) : '' }}" />
                            </div>
                            <div class="col-sm-6">
                                <x-elements.select label="Vergi Oranı" class="choices" id="status" name="tax"
                                    :status="$tax" defaultValue="{{ $item->tax ?? '' }}"></x-elements.select>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <x-elements.input type="file" label="Ürün Resmi" id="image" name="image[]"
                                            multiple="multiple" />
                                    </div>
                                    <div class="col-6">
                                    </div>
                                </div>
                                <div class="row">
                                    @isset($item->images)
                                        @foreach (json_decode($item->images) as $image)
                                            <div class="col">
                                                <img src="{{ asset($image) }}" width="150" />
                                            </div>
                                        @endforeach
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
