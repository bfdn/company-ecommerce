<x-bootstrap.table :class="'table-striped table-hover table-responsive'">
    <x-slot:rows>
        @if ($logtype == 'App\Models\User')
            {{-- <tr>
                <td>Image</td>
                <td>
                    @if (!empty($data->image))
                        <img src="{{ asset($data->image) }}" height="60" data-aos="flip-right">
                    @endif
                </td>
            </tr> --}}
            <tr>
                <td>Name</td>
                <td>{{ $data->name ?? '' }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $data->email }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if ($data->status)
                        <a href="javascript:void(0)" class="btn btn-success btn-sm">Aktif</a>
                    @else
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm">Pasif</a>
                    @endif
                </td>
            </tr>
            {{-- <tr>
                <td>Is Admin</td>
                <td>
                    @if ($data->is_admin)
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm">Admin</a>
                    @else
                        <a href="javascript:void(0)" class="btn btn-secondary btn-sm">User</a>
                    @endif
                </td>
            </tr> --}}
        @endif
    </x-slot:rows>
</x-bootstrap.table>
