@extends('layouts.admin')
@section('title')
    Kullanıcı Logları
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/highlighter-default.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('assets/front/js/highlight.min.js') }}"></script>
    <script>
        hljs.highlightAll();
    </script>
    <script>
        $(document).ready(function() {
            $('.btnModelLogDetail').click(function() {
                let logID = $(this).data('id');
                let self = $(this);
                let route = "{{ route('admin.dblogs.getLog', ['id' => ':id']) }}";
                route = route.replace(":id", logID);
                // console.log(route);
                $.ajax({
                    method: "get",
                    url: route,
                    async: false,
                    success: function(data) {
                        $('#modalBody').html(data);
                        // console.log(data);
                    },
                    error: function() {
                        // console.log("hata geldi");
                    }
                })


            });

            $('.btnDataDetail').click(function() {
                let logID = $(this).data('id');
                let self = $(this);
                let route = "{{ route('admin.dblogs.getLog', ['id' => ':id']) }}";
                route = route.replace(":id", logID);
                // console.log(route);
                $.ajax({
                    method: "get",
                    url: route,
                    async: false,
                    data: {
                        data_type: "data"
                    },
                    success: function(data) {
                        $('#modalBody').html("");
                        // <pre><code class="language-json" id="jsonData"></code></pre>
                        let pre = document.createElement("pre");
                        let code = document.createElement("code");
                        code.setAttribute("class", "language-json");
                        code.setAttribute("id", "jsonData");
                        pre.appendChild(code);
                        $('#modalBody').html(pre);

                        //
                        $('#jsonData').html(JSON.stringify(data, null, 2));
                        // console.log(data);

                        document.querySelectorAll('#jsonData').forEach((block) => {
                            hljs.highlightElement(block)
                        })
                    },
                    error: function() {
                        // console.log("hata geldi");
                    }
                })
            });
        });
    </script>
@endsection
@push('style')
@endpush
@push('javascript')
@endpush
@section('content')
    <x-elements.card>
        <x-slot:header>

        </x-slot:header>
        <x-slot:content>

            <x-elements.table id="dTable1" :class="'table-bordered table-striped'">
                <x-slot:columns>
                    <tr>
                        <th scope="col">Action</th>
                        <th scope="col">Model</th>
                        <th scope="col">Model View</th>
                        <th scope="col">İşlemi Yapan</th>
                        <th scope="col">Data</th>
                        <th scope="col">Tarih</th>
                    </tr>
                </x-slot:columns>
                <x-slot name="rows">
                    @foreach ($items as $item)
                        <tr id="row-{{ $item->id }}">
                            <td>{{ $item->action }}</td>
                            <td>{{ $item->loggable_type }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-info btn-sm btnModelLogDetail"
                                    data-bs-toggle="modal" data-bs-target="#contentViewModal" data-id="{{ $item->id }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                            <td>
                                {{ $item->user->name ?? '' }}
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm btnDataDetail"
                                    data-bs-toggle="modal" data-bs-target="#contentViewModal" data-id="{{ $item->id }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                    @endforeach


                </x-slot>
            </x-elements.table>
        </x-slot:content>
    </x-elements.card>





    <div class="modal fade" id="contentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Log Detayı</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <pre><code class="language-json" id="jsonData"></code></pre>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>
@endsection
