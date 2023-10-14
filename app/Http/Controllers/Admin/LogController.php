<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;


class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = Log::with(['loggable', 'user'])->orderBy("id", "DESC")->get();
        return view('admin.logs.index', ['items' => $logs]);
    }

    public function getLog(Request $request)
    {
        $id = $request->id;
        $dataType = $request->data_type;

        $log = Log::query()->with("loggable")->findOrFail($id);

        $logtype = $log->loggable_type;

        // dd($log->data);
        //dd($log, $logtype);

        //dd($log->data);

        $data = json_decode($log->data);
        if ($dataType == "data") {
            // dd($data);
            return response()->json()->setData($data)->setStatusCode(200);
            // return view('admin.logs.data-log-view', compact("data", 'logtype'));
        }

        $data = $log->loggable;
        return view('admin.logs.model-log-view', compact("data", 'logtype'));
    }
}
