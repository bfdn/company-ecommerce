<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    /* Get Roles */
    public function getRoles(Request $request)
    {
        $user = Auth::user();
        $column = $request->order[0]['column'];
        $columnName = $request->columns[$column]['data'];
        $columnOrder = $request->order[0]['dir'];
        $roles = Role::query()
            ->searchText($request->search['value'])
            ->when(($request->start || $request->length) && $request->length != -1, function ($query) use ($request) {
                $query->offset($request->start)
                    ->limit($request->length);
                return $query;
            })
            ->orderBy($columnName, $columnOrder)
            ->get();

        $roles = $roles->map(function ($item, $key) use ($user) {
            $edit_url = route('admin.role.edit', ['role' => $item->id]);
            $delete_url = route('admin.role.destroy', ['role' => $item->id]);
            $item->button = "";
            if ($user->can('Rol Düzenle')) {
                $item->button .= "<a href='" . $edit_url . "' class='btn btn-primary btn-sm'><i class='bi bi-pencil'></i></a>";
            }
            if ($user->can('Rol Sil')) {
                $item->button .= " <button type='button' class='btn btn-danger btn-sm btnDelete' data-url='" . $delete_url . "'><i class='bi bi-trash'></i></button>";
            }
            return $item;
        });

        $total_count = Role::count();
        $response = [];
        $response['data'] = $roles;
        $response['recordsTotal'] = $total_count;
        $response['recordsFiltered'] = $request->search['value'] ? $roles->count() : $total_count;

        return $response;
        // return response()
        //     ->json()
        //     ->setData($response)
        //     ->setStatusCode(200)
        //     ->setCharset("utf-8")
        //     ->header("content-type", "application/json")
        //     ->setEncodingOptions(JSON_UNESCAPED_UNICODE)
        //     ->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }
}
