@extends('layouts.front')
@section('title')
    {{ $page_title }}
@endsection

@section('meta')
    <meta name="description" content="{{ isset($item) ? $item->seo_description : '' }}">
    <meta name="keywords" content="{{ isset($item) ? $item->seo_keywords : '' }}">
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/front/lib/sweetalert2/sweetalert2.min.css') }}">
@endsection
@push('style')
@endpush




@section('content')
    <x-front.breadcrumb :breadcrumbs="$breadcrumbs ?? ''" />


    <!-- dashboard Secton Start  -->
    <div class="dashboard section">
        <div class="container">
            <div class="row dashboard__content">
                <div class="col-lg-3">
                    @include('front.profile-menu')
                </div>
                <div class="col-lg-9 section--xl pt-0">
                    <div class="container">
                        <!-- Account Settings  -->
                        <div class="dashboard__content-card">
                            <div class="dashboard__content-card-header">
                                <h5 class="font-body--xxl-500">Ayarlar</h5>
                            </div>
                            <div class="dashboard__content-card-body">
                                <div class="row">
                                    <div class="col-lg-12 order-lg-0 order-2">
                                        <form action="{{ route('front.profile.settings-update') }}" id="settingsForm">
                                            <div class="contact-form__content">
                                                <div class="contact-form-input">
                                                    <label for="email1">Email </label>
                                                    <input type="text" id="email1" name="email"
                                                        value="{{ $user->email }}" placeholder="" />
                                                </div>
                                          
                                                <div class="contact-form-btn">
                                                    <button class="button button--md" id="settingsUpdate" type="submit">
                                                        Güncelle
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <!-- Change Password  -->
                        <div class="dashboard__content-card">
                            <div class="dashboard__content-card-header">
                                <h5 class="font-body--xxl-500">Parola Güncelleme</h5>
                            </div>
                            <div class="dashboard__content-card-body">
                                <form action="{{ route('front.profile.password-update') }}" id="passwordForm">
                                    <div class="contact-form__content">
                                        <div class="contact-form-input">
                                            <label for="cpassword">Şimdiki Parola </label>
                                            <input type="password" id="cpassword" name="password" placeholder="Parola" />
                                            <span class="icon" onclick="showPassword('cpassword',this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-eye">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="contact-form__content-group">
                                            <!-- New Password  -->
                                            <div class="contact-form-input">
                                                <label for="npassword">Yeni Parola </label>
                                                <input type="password" id="npassword" name="npassword" placeholder="Parola" />
                                                <span class="icon" onclick="showPassword('npassword',this)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-eye">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </span>
                                            </div>
                                            <!-- confirm  Password  -->
                                            <div class="contact-form-input">
                                                <label for="confirmPassword">Yeni Parola Tekrar</label>
                                                <input type="password" id="confirmPassword" placeholder="Parola" name="npasswordr" />
                                                <span class="icon" onclick="showPassword('confirmPassword',this)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-eye">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="contact-form-btn">
                                            <button class="button button--md passwordChange" type="button">
                                                Güncelle
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- dashboard Secton  End  -->
@endsection




@section('js')
    <script src="{{ asset('assets/front/lib/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
@push('javascript')
@endpush
