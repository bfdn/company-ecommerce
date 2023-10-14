@extends('layouts.admin')
@section('title')
    Panel Anasayfa
@endsection


@section('content')
    <x-bootstrap.card>
        <x-slot:header>Api</x-slot:header>
        <x-slot:content>
            <ol>
                <li>Blog</li>

                <li>
                    Tüm Kayıtlar
                    <br>
                    Metod: GET
                    <br>
                    Link:
                    <br>
                    {{ route('blog.index') }}
                </li>
                <li>
                    Tek Kayıt
                    <br>
                    Metod: GET
                    <br>
                    Link:
                    <br>
                    {{ route('blog.show', ['blog' => 1]) }}
                </li>
                <li>
                    Kayıt Ekleme
                    <br>
                    Metod: POST
                    <br>
                    Link:
                    <br>
                    {{ route('blog.store') }}
                </li>
                <li>
                    Kayıt Güncelleme
                    <br>
                    Metod: PUT
                    <br>
                    Link:
                    <br>
                    {{ route('blog.update', ['blog' => 1]) }}
                </li>
                <li>
                    Kayıt Silme
                    <br>
                    Metod: DELETE
                    <br>
                    Link:
                    <br>
                    {{ route('blog.destroy', ['blog' => 1]) }}
                </li>
            </ol>
        </x-slot:content>
    </x-bootstrap.card>
@endsection








@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/choices.js/public/assets/styles/choices.css') }}">
@endpush
@push('javascript')
    <script src="{{ asset('assets/admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    {{-- <script src="{{ asset('assets/admin/js/pages/simple-datatables.js') }}"></script> --}}
@endpush
