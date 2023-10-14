@php $shoppingCart = session('shoppingCart'); @endphp
<div class="loader">
    <div class="loader-icon">
        <img src="{{ asset('assets/front/images/loader.gif') }}" alt="loader" />
    </div>
</div>


<!-- Header Section start -->
<header class="header header--one">
    <div class="header__top">
        <div class="container">
            <div class="header__top-content">
                <div class="header__top-left">
                    <p class="font-body--sm">
                        <span>
                            <svg width="17" height="20" viewBox="0 0 17 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16 8.36364C16 14.0909 8.5 19 8.5 19C8.5 19 1 14.0909 1 8.36364C1 6.41068 1.79018 4.53771 3.1967 3.15676C4.60322 1.77581 6.51088 1 8.5 1C10.4891 1 12.3968 1.77581 13.8033 3.15676C15.2098 4.53771 16 6.41068 16 8.36364Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M8.5 10.8182C9.88071 10.8182 11 9.71925 11 8.36364C11 7.00803 9.88071 5.90909 8.5 5.90909C7.11929 5.90909 6 7.00803 6 8.36364C6 9.71925 7.11929 10.8182 8.5 10.8182Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        {{ $settings->phone_1 }}
                    </p>
                </div>
                <div class="header__top-right">
                    <div class="header__dropdown">


                        <ul class="header__navigation-menu">
                            <!-- Shopepages -->
                            <li class="header__navigation-menu-link lang">
                                <a href="#">{{ strtoupper(config('app.locale')) }}
                                    <span class="drop-icon">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.33332 5.66667L7.99999 10.3333L12.6667 5.66667"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                </a>

                                <ul class="header__navigation-drop-menu">
                                    @foreach ($langs as $lang)
                                        <li class="header__navigation-drop-menu-link">
                                            <a
                                                href="{{ route('front.index', ['locale' => $lang->short_name]) }}">{{ $lang->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>


                    </div>
                    <div class="header__in">
                        @if (Auth::user())
                            <span><a href="{{ route('front.profile') }}">{{ Auth::user()->name }}</a></span>
                            <span>/</span>

                            <a href="#"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('front.logout') }}
                            </a>
                            <form action="{{ route('logout') }}" method="post" id="logout-form">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('front.register') }}">{{ __('front.register') }} </a>
                            <span>/</span>
                            <a href="{{ route('front.login') }}">{{ __('front.login') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header__center">
        <div class="container">
            <div class="header__center-content">
                <div class="header__brand">
                    <button class="header__sidebar-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 12H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M3 6H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M3 18H15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                    <a href="/">
                        <img src="{{ asset($settings->logo) }}" alt="brand-logo" />
                    </a>
                </div>
                <form action="{{ route('front.productSearch') }}">
                    <div class="header__input-form">
                        <input type="text" name="pq" placeholder="{{ __('front.search') }}"
                            value="{{ request()->get('pq') }}" />
                        <span class="search-icon">
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.16667 16.3333C12.8486 16.3333 15.8333 13.3486 15.8333 9.66667C15.8333 5.98477 12.8486 3 9.16667 3C5.48477 3 2.5 5.98477 2.5 9.66667C2.5 13.3486 5.48477 16.3333 9.16667 16.3333Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M17.4999 18L13.8749 14.375" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <button type="submit" class="search-btn button button--md">
                            {{ __('front.search') }}
                        </button>
                    </div>
                </form>

                <div class="header__cart">
                    <div class="header__cart-item">
                    </div>
                    <div class="header__cart-item">
                        <div class="header__cart-item-content" id="cart-bag">
                            <a href="{{ route('front.cartList') }}" class="cart-bag">
                                <svg width="34" height="35" viewBox="0 0 34 35" fill="none"
                                    class="text-black" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.3333 14.6667H7.08333L4.25 30.25H29.75L26.9167 14.6667H22.6667M11.3333 14.6667V10.4167C11.3333 7.28705 13.8704 4.75 17 4.75V4.75C20.1296 4.75 22.6667 7.28705 22.6667 10.4167V14.6667M11.3333 14.6667H22.6667M11.3333 14.6667V18.9167M22.6667 14.6667V18.9167"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <span class="item-number">{{ $shoppingCart['summary']->total_qty ?? '0' }}</span>
                            </a>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="header__bottom">
        <div class="container">
            <div class="header__bottom-content">
                <ul class="header__navigation-menu">
                    <li class="header__navigation-menu-link active">
                        <a href="/">{{ __('menu.home') }}</a>
                    </li>



                    @isset($headerMenuCategories)
                        @foreach ($headerMenuCategories as $category)
                            <x-front.header-menu :category="$category"
                                slug="{{ '/' . request('locale') . '/' . __('route.category') }}" first="true" />
                        @endforeach
                    @endisset


                    <li class="header__navigation-menu-link">
                        <a href="{{ route('front.blog') }}">{{ __('menu.blog') }}</a>
                    </li>

                </ul>

                <a href="#" class="header__telephone-number">
                    <span>
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.4359 2.375C15.9193 2.77396 17.2718 3.55567 18.358 4.64184C19.4441 5.72801 20.2258 7.08051 20.6248 8.56388"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M13.5306 5.75687C14.4205 5.99625 15.2318 6.46521 15.8833 7.11678C16.5349 7.76835 17.0039 8.57967 17.2433 9.46949"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M7.115 11.6517C8.02238 13.5074 9.5263 15.0049 11.3859 15.9042C11.522 15.9688 11.6727 15.9966 11.8229 15.9851C11.9731 15.9736 12.1178 15.9231 12.2425 15.8386L14.9812 14.0134C15.1022 13.9326 15.2414 13.8833 15.3862 13.8698C15.5311 13.8564 15.677 13.8793 15.8107 13.9364L20.9339 16.1326C21.1079 16.2065 21.2532 16.335 21.3479 16.4987C21.4426 16.6623 21.4815 16.8523 21.4589 17.04C21.2967 18.307 20.6784 19.4714 19.7196 20.3154C18.7608 21.1593 17.5273 21.6249 16.25 21.625C12.3049 21.625 8.52139 20.0578 5.73179 17.2682C2.94218 14.4786 1.375 10.6951 1.375 6.75C1.37512 5.47279 1.84074 4.23941 2.68471 3.28077C3.52867 2.32213 4.6931 1.70396 5.96 1.542C6.14771 1.51936 6.33769 1.55832 6.50134 1.653C6.66499 1.74769 6.79345 1.89298 6.86738 2.067L9.06537 7.1945C9.1219 7.32698 9.14485 7.47137 9.13218 7.61485C9.11951 7.75833 9.07162 7.89647 8.99275 8.017L7.17275 10.7977C7.09015 10.923 7.04141 11.0675 7.03129 11.2171C7.02117 11.3668 7.05001 11.5165 7.115 11.6517V11.6517Z"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        {{ $settings->phone_2 }}
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="header__sidebar">
        <button class="header__cross">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
        <div class="header__mobile-sidebar">
            <div class="header__mobile-top">
                <form action="{{ route('front.productSearch') }}">
                    <div class="header__mobile-input">
                        <input type="text" name="pq" placeholder="{{ __('front.search') }}"
                            value="{{ request()->get('pq') }}" />
                        <button type="submit" class="search-btn">
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.16667 16.3333C12.8486 16.3333 15.8333 13.3486 15.8333 9.66667C15.8333 5.98477 12.8486 3 9.16667 3C5.48477 3 2.5 5.98477 2.5 9.66667C2.5 13.3486 5.48477 16.3333 9.16667 16.3333Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M17.4999 18L13.8749 14.375" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </form>
                <ul class="header__mobile-menu">
                    <li class="header__mobile-menu-item active">
                        <a href="/" class="header__mobile-menu-item-link">
                            {{ __('menu.home') }}
                        </a>
                    </li>

                    @isset($headerMenuCategories)
                        @foreach ($headerMenuCategories as $category)
                            <x-front.header-menu :category="$category"
                                slug="{{ '/' . request('locale') . '/' . __('route.category') }}" first="true"
                                mobile="true" />
                        @endforeach
                    @endisset

                    <li class="header__mobile-menu-item">
                        <a class="header__mobile-menu-item-link"
                            href="{{ route('front.blog') }}">{{ __('menu.blog') }}</a>
                    </li>

                </ul>
            </div>
            <div class="header__mobile-bottom">

            </div>
        </div>
    </div>
</header>
<!-- Header  Section start -->
