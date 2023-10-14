@extends('layouts.front')
@section('title')
    {{ $page_title }}
@endsection

@section('meta')
    <meta name="description" content="{{ isset($item) ? $item->seo_description : 'Blog yazılar listesi' }}">
    <meta name="keywords" content="{{ isset($item) ? $item->seo_keywords : 'Blog keyword' }}">
@endsection
@section('css')
@endsection
@push('style')
@endpush




@section('content')
    <x-front.breadcrumb :breadcrumbs="$breadcrumbs" />



    <!-- Blog-list section start  -->
    <section class="blog-list section">
        <div class="container">
            <div class="row blog-list__wrapper shop-content">
                <div class="col-lg-3">
                    <div class="sidebar">

                        <div class="blog__sidebar">
                            <x-front.blog-search :searchText="$searchText ?? ''" />

                            <x-front.blog-categories :blogCategories="$blogCategories" />

                            <x-front.blog-last :lastArticles="$lastArticles" />

                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <!-- Desktop Version  -->
                    <div class="row blog-list__content--desktop">
                        @foreach ($articles as $article)
                            <div class="col-xl-6 custom-col">
                                <x-front.blog-item :item="$article" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Mobile Version  -->
                    <div class="blog-list--slider swiper-container">
                        <div class="swiper-wrapper">

                            @foreach ($articles as $article)
                                <div class="swiper-slide">
                                    <x-front.blog-item :item="$article" />
                                </div>
                            @endforeach

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>

                    {{ $articles->onEachside(0)->links('front.paginate') }}



                </div>
            </div>
        </div>
    </section>
    <!-- Blog-list section  end  -->
@endsection




@section('js')
@endsection
@push('javascript')
@endpush
