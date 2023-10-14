@extends('layouts.admin')
@section('title')
    Rol {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
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
            Rol {{ isset($item) ? 'Güncelleme' : 'Ekleme' }}
            <a href="{{ route('admin.role.index') }}" class="btn btn-secondary float-end"><i class="bi bi-arrow-left"></i> Geri
                Dön</a>
        </x-slot:header>
        <x-slot:content>

            <form action="{{ isset($item) ? route('admin.role.update', ['role' => $item->id]) : route('admin.role.store') }}"
                id="Form">
                @csrf
                @method(isset($item) ? 'PUT' : 'POST')
                <div class="row">
                    <div class="col-sm-12">
                        <x-elements.input type="text" label="Rol Adı" id="name" placeHolder="Rol Adı" name="name"
                            defaultValue="{{ $item->name ?? '' }}" />
                    </div>

                    <div class="row mt-2">
                        <label class="form-label fs-5">İzinler</label>
                        @php $role_permissions = isset($role_permissions)?$role_permissions : []; @endphp
                        @foreach ($permissions->chunk(4) as $indis_chunk => $chunk)
                            <div class="col-3 mb-5 m-t-15">
                                @foreach ($chunk as $indis_perm => $permission)
                                    {{-- <div class="mb-3 m-t-15"> --}}
                                    <x-elements.checkbox :label="$permission->name" :defaultValue="$permission->id" name="permissions[]"
                                        :rolePermissions="$role_permissions" :rolePerm="true" />
                                    {{-- </div> --}}
                                @endforeach
                            </div>
                        @endforeach
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
