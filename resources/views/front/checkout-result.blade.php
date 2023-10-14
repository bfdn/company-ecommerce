@extends('layouts.front')
@section('title')
    {{ $page_title }}
@endsection

@section('meta')
    <meta name="description" content="Ödeme Sonuç">
    <meta name="keywords" content="Ödeme Sonuç">
@endsection
@section('css')
@endsection
@push('style')
@endpush




@section('content')
    <x-front.breadcrumb :breadcrumbs="$breadcrumbs ?? ''" />


    <!-- Shopping Cart Section Start   -->
    <section class="shoping-cart section section--xl">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('layouts.partials.errors')
                    @include('layouts.partials.alert')

                    @if (isset($sonuc))
                        <div class="alert alert-{{ $sonuc['message_type'] }} text-center">{!! $sonuc['message'] !!}</div>
                    @endif


                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End    -->
@endsection




@section('js')
@endsection
@push('javascript')
@endpush
