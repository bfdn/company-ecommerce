<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Events\OrderStatusChangedEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Sipariş Listele|Sipariş Ekle|Sipariş Düzenle|Sipariş Sil', ['only' => ['index', 'show']]);
        $this->middleware('permission:Sipariş Ekle', ['only' => ['create', 'store']]);
        $this->middleware('permission:Sipariş Düzenle', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Sipariş Sil', ['only' => ['destroy']]);
    }

    public function index()
    {
        $orders = Order::query()->with("user")->orderBy("id", "asc")->get();

        return view('admin.orders.index', ['items' => $orders]);
    }

    public function show(Order $order)
    {
        $order_user = $order->user;
        $order_details = $order->details()->with('product')->get();
        $order_status = OrderStatusEnum::cases();

        return view('admin.orders.details', compact('order', 'order_details', 'order_user', 'order_status'));
    }

    public function statusChange(Request $request, Order $order)
    {
        try {
            $validated = $request->validate([
                'data' => ['required'],
            ]);
            // Retrieve the validated input data...

            if ($validated) {
                $status  = $request->data;
                $order->update(['order_status' => $status], ['id' => $order->id]);

                event(new OrderStatusChangedEvent($order->user, $order));
            }

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Sipariş Durumu Başarıyla Güncellendi',
                    'redirect' => to_route("admin.orders.index")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            if (request()->ajax()) {
                return [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !',
                    'redirect' => ''
                ];
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();
            $order->details()->delete();
            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Silindi',
                    'redirect' => to_route("admin.orders.index")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                // dd($th->getMessage());
                return [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !',
                    'redirect' => ''
                ];
            }
        }
    }
}
