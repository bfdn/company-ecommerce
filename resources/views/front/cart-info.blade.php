@extends('layouts.front')
@section('title')
    {{ $page_title }}
@endsection

@section('meta')
    <meta name="description" content="Sepet Bilgi">
    <meta name="keywords" content="Sepet Bilgi">
@endsection
@section('css')
@endsection
@push('style')
@endpush




@section('content')
    <x-front.breadcrumb :breadcrumbs="$breadcrumbs ?? ''" />


    <!-- Billing Section Start  -->
    <section class="section billing section--xl pt-0">
        <div class="container">
            <form action="{{ route('front.cartInfoSend') }}" method="post">
                @csrf
                <div class="row billing__content">

                    <div class="col-lg-8">
                        <div class="billing__content-card">
                            <div class="billing__content-card-header">
                                <h2 class="font-body--xxxl-500">Fatura Bilgileri</h2>

                                @include('layouts.partials.errors')
                                @include('layouts.partials.alert')
                            </div>
                            <div class="billing__content-card-body">

                                <div class="contact-form__content">
                                    <div class="contact-form__content-group">
                                        <div class="contact-form-input">
                                            <label for="fname1">Ad </label>
                                            <input type="text" id="fname1" name="name" placeholder="Adınız"
                                                value="{{ old('name') }}" />
                                        </div>
                                        <div class="contact-form-input">
                                            <label for="lname2">Soyad </label>
                                            <input type="text" id="lname2" name="surname" placeholder="Soyadınız"
                                                value="{{ old('surname') }}" />
                                        </div>
                                        <div class="contact-form-input">
                                            <label for="company">Firma Adı <span>(Opsiyonel)</span>
                                            </label>
                                            <input type="text" id="company" name="company" placeholder="Firma Adı"
                                                value="{{ old('company') }}" />
                                        </div>
                                    </div>

                                    <div class="contact-form-input">
                                        <label for="address">Adres </label>
                                        <input type="text" id="address" name="address" placeholder="Adres"
                                            value="{{ old('address') }}" />
                                    </div>


                                    <div class="contact-form__content-group">
                                        <div class="contact-form-input">
                                            <label for="email"> email </label>
                                            <input type="email" id="email" name="email"
                                                placeholder="Email Adresiniz" value="{{ old('email') }}" />
                                        </div>
                                        <div class="contact-form-input">
                                            <label for="phone"> Phone </label>
                                            <input type="number" id="phone" name="phone"
                                                placeholder="Telefon Numarası" value="{{ old('phone') }}" />
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="same_address" id="remember"
                                            @checked(old('same_address')) />
                                        <label class="form-check-label font-body--md-400" for="remember">
                                            Teslimat adresi fatura adresi ile aynı
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="billing__content-card">
                            <div class="billing__content-card-header">
                                <h2 class="font-body--xxxl-500">Ek Bilgiler</h2>
                            </div>
                            <div class="billing__content-card-body">
                                <div class="contact-form-input contact-form-textarea">
                                    <label for="note">Sipariş Notu<span>(Opsiyonel)</span> </label>
                                    <!-- <input type="text" id="fname1" placeholder="Your first name" /> -->
                                    <textarea name="notes" id="note" placeholder="Siparişiniz ile ilgili ekstra bilgi">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="bill-card">
                            <div class="bill-card__content">
                                <div class="bill-card__header">
                                    <h2 class="bill-card__header-title font-body--xxl-500">
                                        Sipariş Özeti
                                    </h2>
                                </div>
                                <div class="bill-card__body">

                                    <!-- memo  -->
                                    <div class="bill-card__memo">
                                        <!-- Subtotal  -->
                                        <div class="bill-card__memo-item subtotal">
                                            <p class="font-body--md-400">Ara Toplam:</p>
                                            <span
                                                class="font-body--md-500">{{ getMoneyFormat($summary->total_price ?? 0) . ' TL' }}</span>
                                        </div>
                                        <!-- Shipping  -->
                                        <div class="bill-card__memo-item shipping">
                                            <p class="font-body--md-400">Kdv:</p>
                                            <span
                                                class="font-body--md-500">{{ getMoneyFormat($summary->tax_total_price ?? 0) . ' TL' }}</span>
                                        </div>
                                        <!-- total  -->
                                        <div class="bill-card__memo-item total">
                                            <p class="font-body--lg-400">Genel Toplam:</p>
                                            <span
                                                class="font-body--xl-500">{{ getMoneyFormat(($summary->total_price ?? 0) + ($summary->tax_total_price ?? 0)) . ' TL' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bill-card__content">
                                <div class="bill-card__header">
                                    <div class="bill-card__header">
                                        <h2 class="bill-card__header-title font-body--xxl-500">
                                            Ödeme Seçenekleri
                                        </h2>
                                    </div>
                                </div>
                                <div class="bill-card__body">

                                    <!-- Payment Methods  -->
                                    <div class="bill-card__payment-method">
                                        <div class="bill-card__payment-method-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    id="cash" value="1" />
                                                <label class="form-check-label font-body--400" for="cash">
                                                    Kapıda Ödeme
                                                </label>
                                            </div>
                                        </div>

                                        <div class="bill-card__payment-method-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    id="paypal" value="2" />
                                                <label class="form-check-label font-body--400" for="paypal">
                                                    Kredi Kartı
                                                </label>
                                            </div>
                                        </div>

                                    </div>

                                    <button class="button button--lg w-100 buttonInfo" type="submit">
                                        Ödeme Yap
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>
    <!-- Billing Section  End  -->
@endsection




@section('js')
@endsection
@push('javascript')
@endpush
