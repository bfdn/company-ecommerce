@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/choices.js/public/assets/styles/choices.css') }}">
@endsection

@section('js')
    <script src="{{ asset('assets/admin/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
@endsection
@section('title')
    Ayarlar
@endsection



@section('content')
    <x-elements.card>
        <x-slot:header>
            Ayarlar
        </x-slot:header>
        <x-slot:content>
            <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data" id="Form">
                @csrf



                <div class="row">
                    <div class="col-sm-6">
                        <x-elements.input type="text" label="Telefon 1" id="phone_1" placeHolder="Telefon 1"
                            name="phone_1" defaultValue="{{ $item->phone_1 }}" />
                    </div>
                    <div class="col-sm-6">
                        <x-elements.input type="text" label="Telefon 2" id="phone_2" placeHolder="Telefon 2"
                            name="phone_2" defaultValue="{{ $item->phone_2 }}" />
                    </div>
                    <div class="col-sm-4">
                        <x-elements.input type="text" label="Blogda Kaç Yazı Listelensin" id="blog_articles"
                            placeHolder="" name="blog_articles" defaultValue="{{ $item->blog_articles }}" />
                    </div>

                    <div class="col-sm-4">
                        <x-elements.input type="text" label="Kategoride Kaç Ürün Listelensin" id="category_products"
                            placeHolder="" name="category_products" defaultValue="{{ $item->category_products }}" />
                    </div>
                    <div class="col-sm-4">
                        <x-elements.input type="text" label="Blog Kategoride Kaç Yazı Listelensin" id="category_articles"
                            placeHolder="" name="category_articles" defaultValue="{{ $item->category_articles }}" />
                    </div>
                    <div class="col-sm-4">
                        <x-elements.input type="text" label="Anasayfa Kaç Ürün Listelensin" id="home_products"
                            placeHolder="" name="home_products" defaultValue="{{ $item->home_products }}" />
                    </div>
                    <div class="col-sm-4">
                        <x-elements.input type="text" label="Anasayfa Kaç Blog Yazısı Listelensin" id="home_articles"
                            placeHolder="" name="home_articles" defaultValue="{{ $item->home_articles }}" />
                    </div>

                    <div class="col-12">
                        <x-elements.input type="text" label="Seo Keywords" id="seo_keywords" placeHolder=""
                            name="seo_keywords" defaultValue="{{ $item->seo_keywords }}" />
                    </div>

                    <div class="col-12">
                        <x-elements.input type="text" label="Seo Description" id="seo_description" placeHolder=""
                            name="seo_description" defaultValue="{{ $item->seo_description }}" />
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <x-elements.input type="file" label="Logo" id="logo" name="logo" />
                            </div>
                            <div class="col-6">
                                <img src="{{ asset($item->logo) }}" width="100" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <x-elements.select :label="'Yorumlar Onaylı mı Olsun?'" :class="'choices'" :id="'test'" :name="'comments_status'"
                            :status="$comments_status" defaultValue="{{ $item->comments_status }}"></x-elements.select>
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

@push('javascript')
@endpush
