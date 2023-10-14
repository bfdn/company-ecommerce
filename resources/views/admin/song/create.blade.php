@extends('layouts.admin')
@section('title')
    Kullanıcı Ekle
@endsection
@section('css')
@endsection
@section('js')
@endsection
@push('style')
@endpush
@push('javascript')
@endpush
@section('content')
    <x-elements.card>
        <x-slot:header>
            Kullanıcı Ekle
        </x-slot:header>
        <x-slot:content>
            {!! form($form) !!}
        </x-slot:content>
    </x-elements.card>
@endsection
