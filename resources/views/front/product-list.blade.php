@extends('layouts.front')
@section('title')
    {{ $page_title }}
@endsection

@section('meta')
    <meta name="description" content="{{ isset($item) ? $item->seo_description : '' }}">
    <meta name="keywords" content="{{ isset($item) ? $item->seo_keywords : '' }}">
@endsection
@section('css')
@endsection
@push('style')
    <style>
        .shop .categories-item a {
            cursor: pointer;
            font-size: 14px;
            line-height: 21px;
            color: #1a1a1a;
            font-weight: 400;
            text-transform: capitalize;
        }

        /* Chrome, Safari, Edge, Opera */
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        select[name=sort] {
            appearance: auto;
        }
    </style>
@endpush




@section('content')
    <x-front.breadcrumb :breadcrumbs="$breadcrumbs ?? ''" />



    <!-- Filter  -->
    <div class="filter--search">
        <div class="container">
            <div class="filter--search__content row">
                <div class="col-lg-3 d-none d-lg-block">
                    <button class="button button--md" id="filter">
                        Filter
                        <span>
                            <svg width="22" height="19" viewBox="0 0 22 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18 5.75C18.4142 5.75 18.75 5.41421 18.75 5C18.75 4.58579 18.4142 4.25 18 4.25V5.75ZM9 4.25C8.58579 4.25 8.25 4.58579 8.25 5C8.25 5.41421 8.58579 5.75 9 5.75V4.25ZM18 4.25H9V5.75H18V4.25Z"
                                    fill="white" />
                                <path
                                    d="M13 14.75C13.4142 14.75 13.75 14.4142 13.75 14C13.75 13.5858 13.4142 13.25 13 13.25V14.75ZM4 13.25C3.58579 13.25 3.25 13.5858 3.25 14C3.25 14.4142 3.58579 14.75 4 14.75V13.25ZM13 13.25H4V14.75H13V13.25Z"
                                    fill="white" />
                                <circle cx="5" cy="5" r="4" stroke="white" stroke-width="1.5" />
                                <circle cx="17" cy="14" r="4" stroke="white" stroke-width="1.5" />
                            </svg>
                        </span>
                    </button>
                </div>
                <div class="col-lg-9">
                    <div class="filter--search-result">
                        <div class="sort-list">
                            <label for="sort">Sırala:</label>
                            <select class="form-control" name="sort">
                                <option value="artanfiyat" {{ request()->get('sort') == 'artanfiyat' ? 'selected' : '' }}>En
                                    Düşük Fiyat</option>
                                <option value="azalanfiyat" {{ request()->get('sort') == 'azalanfiyat' ? 'selected' : '' }}>
                                    En
                                    Yüksek Fiyat</option>
                                <option value="last"
                                    {{ request()->get('sort') == 'last' || request()->get('sort') == null ? 'selected' : '' }}>
                                    Yeni Eklenenler</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Shop list Section Start  -->
    <section class="shop shop--one">
        <div class="container">
            <div class="row shop-content">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <!-- filter button -->
                        <button class="filter">
                            <svg width="22" height="19" viewBox="0 0 22 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18 5.75C18.4142 5.75 18.75 5.41421 18.75 5C18.75 4.58579 18.4142 4.25 18 4.25V5.75ZM9 4.25C8.58579 4.25 8.25 4.58579 8.25 5C8.25 5.41421 8.58579 5.75 9 5.75V4.25ZM18 4.25H9V5.75H18V4.25Z"
                                    fill="white"></path>
                                <path
                                    d="M13 14.75C13.4142 14.75 13.75 14.4142 13.75 14C13.75 13.5858 13.4142 13.25 13 13.25V14.75ZM4 13.25C3.58579 13.25 3.25 13.5858 3.25 14C3.25 14.4142 3.58579 14.75 4 14.75V13.25ZM13 13.25H4V14.75H13V13.25Z"
                                    fill="white"></path>
                                <circle cx="5" cy="5" r="4" stroke="white" stroke-width="1.5">
                                </circle>
                                <circle cx="17" cy="14" r="4" stroke="white" stroke-width="1.5">
                                </circle>
                            </svg>
                        </button>
                        <div class="shop__sidebar-content">
                            <form action="">
                                <div class="accordion shop" id="shop">
                                    <!-- All Categories  -->
                                    <div class="accordion-item shop-item">
                                        <h2 class="accordion-header" id="shop-item-accordion--one">
                                            <button class="accordion-button shop-button font-body--xxl-500" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                {{ __('front.categories') }}
                                                <span class="icon">
                                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13 7L7 1L1 7" stroke="#1A1A1A" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse shop-collapse collapse show show"
                                            aria-labelledby="shop-item-accordion--one" data-bs-parent="#shop">
                                            <div class="accordion-body shop-body">
                                                <div class="categories">
                                                    @foreach ($childrenCategories as $childrenCategory)
                                                        <div class="categories-item">
                                                            <a
                                                                href="{{ route('front.categoryProductList', ['category' => $category->slug . '/' . $childrenCategory->slug]) }}">{{ $childrenCategory->name }}</a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Price Range -->
                                    <div class="accordion-item shop-item">
                                        <h2 class="accordion-header" id="shop-item-accordion--two">
                                            <button class="accordion-button shop-button font-body--xxl-500 collapsed"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                {{ __('front.price') }}
                                                <span class="icon">
                                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13 7L7 1L1 7" stroke="#1A1A1A" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse shop-collapse collapse show"
                                            aria-labelledby="shop-item-accordion--two" data-bs-parent="#shop">
                                            <div class="row mb-3 mt-2">
                                                <div class="col-sm-6">
                                                    <input type="number" name="min" placeholder="Min"
                                                        class="form-control" value="{{ request()->get('min') }}">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="number" name="max" placeholder="Max"
                                                        class="form-control" value="{{ request()->get('max') }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="accordion-item shop-item">
                                        <button type="submit"
                                            class="button button--lg">{{ __('front.filter') }}</button>
                                    </div>
                                </div>


                            </form>


                        </div>
                    </div>
                </div>
                <div class="col-lg-9" id="productList">
                    @include('front.product-wrapper', ['products' => $products])
                </div>
            </div>
        </div>
    </section>
    <!-- Shop list Section End   -->
@endsection




@section('js')
    <script>
        $("select[name='sort']").on('change', function() {
            let link = location.origin + location.pathname;
            let sortVal = $(this).val();

            link += location.search == '' ? '?sort=' + sortVal : location.search + "&sort=" + sortVal;




            $.ajax({
                type: "get",
                url: link,
                success: function(response) {
                    $('#productList').html(response.data);
                    window.history.pushState("", "", response.link);
                }
            });
        });
    </script>
@endsection
@push('javascript')
    <script src="{{ asset('assets/front/lib/js/nouislider.min.js') }}"></script>
@endpush
