<?php

namespace App\Http\Controllers\Front;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentTypeEnum;
use App\Events\OrderCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartInfoRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function cartList(Request $request)
    {
        $shoppingCart = $request->session()->get('shoppingCart');
        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
            [
                "name" => __('front.cart'),
                "link" => "#"
            ]
        ];
        $page_title = __('front.cart') . ' | ' . config('app.name');
        $data = [
            'page_title' => $page_title,
            'breadcrumbs' => $breadcrumbs,
            'products' => $shoppingCart['products'] ?? '',
            'summary' => $shoppingCart['summary'] ?? ''
        ];
        return view('front.cart-list', $data);
    }

    public function addToCart(Request $request)
    {
        $product_id = decrypt($request->p);
        $product = Product::query()->select("id", "name", "slug", "images", "price", "tax")->where(["id" => $product_id, "status" => 1])->firstOrFail();
        $product->qty = 1;
        $product->tax_price = (($product->price * $product->qty) / 100) * $product->tax->value;

        // $request->session()->put('key', 'value');
        if ($request->session()->has('shoppingCart')) {
            $shoppingCart = $request->session()->get("shoppingCart");
            $products = $shoppingCart["products"];
        } else {
            $products = array();
        }

        if (array_key_exists($product->id, $products)) {
            $products[$product->id]->qty++;
            $products[$product->id]->tax_price = (($product->price * $products[$product->id]->qty) / 100) * $product->tax->value;
        } else {
            $products[$product->id] = $product;
        }


        $summary = $this->cartCalculate($products);

        session()->regenerate();


        return response()->json(
            [
                'total_qty' => $summary->total_qty,
                "token" => csrf_token()
            ],
            200
        );
    }

    public function cartCalculate(array $products)
    {
        // Sepetin Hesaplanması
        $total_price = 0.0;
        $tax_total_price = 0.0;
        $total_qty = 0;

        foreach ($products as $product) {
            $product->total_price = $product->qty * $product->price;

            $total_price = $total_price + $product->total_price;

            $tax_total_price += $product->tax_price;

            $total_qty += $product->qty;
        }



        $summary = new stdClass();
        $summary->total_price = $total_price;
        $summary->tax_total_price = $tax_total_price;
        $summary->total_qty = $total_qty;

        session(['shoppingCart.products' => $products, 'shoppingCart.summary' => $summary]);

        return $summary;
    }

    public function removeFromCart(Request $request)
    {
        $shoppingCart = $request->session()->get('shoppingCart');
        $products = $shoppingCart['products'];
        $product_id = decrypt($request->p);

        // Ürün Listeden Çıkar
        if (array_key_exists($product_id, $products)) {
            unset($products[$product_id]);
        }

        // Sepeti Hesapla
        $summary = $this->cartCalculate($products);

        return true;
    }

    public function incCount(Request $request)
    {
        $shoppingCart = $request->session()->get('shoppingCart');
        $products = $shoppingCart['products'];
        $product_id = decrypt($request->p);


        if (array_key_exists($product_id, $products)) {
            $products[$product_id]->qty++;
            $products[$product_id]->tax_price = (($products[$product_id]->price * $products[$product_id]->qty) / 100) * $products[$product_id]->tax->value;
        }


        $summary = $this->cartCalculate($products);
        return true;
    }

    public function decCount(Request $request)
    {
        $shoppingCart = $request->session()->get('shoppingCart');
        $products = $shoppingCart['products'];
        $product_id = decrypt($request->p);

        if ($request->qty < 1)
            $this->removeFromCart($request);
        else {
            if (array_key_exists($product_id, $products)) {
                $products[$product_id]->qty--;
                $products[$product_id]->tax_price = (($products[$product_id]->price * $products[$product_id]->qty) / 100) * $products[$product_id]->tax->value;
            }
            $summary = $this->cartCalculate($products);
        }



        return true;
    }

    public function cartInfo(Request $request)
    {
        $shoppingCart = $request->session()->get('shoppingCart');
        if (!$shoppingCart) {
            // return to_route('front.cartList');
            return redirect()->route('front.cartList');
        }
        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
            [
                "name" => __('front.cart'),
                "link" => "#"
            ]
        ];
        $page_title = __('front.cart') . ' | ' . config('app.name');
        $data = [
            'page_title' => $page_title,
            'breadcrumbs' => $breadcrumbs,
            'products' => $shoppingCart['products'] ?? '',
            'summary' => $shoppingCart['summary'] ?? ''
        ];
        return view('front.cart-info', $data);
    }

    public function cartInfoSend(CartInfoRequest $request)
    {
        $shoppingCart = $request->session()->get('shoppingCart');
        $products = $shoppingCart['products'];
        $summary = $shoppingCart['summary'];

        if (!$shoppingCart || !Auth::user()) {
            // return to_route('front.cartList');
            return redirect()->route('front.cartList');
        }

        // Ödeme Tipi kontrol - Kredi kartı mı - kapıda ödeme mi
        $payment_method = $request->payment_method;


        $orderInfo = new Order();
        $orderInfo->fill($request->only('name', 'surname', 'company', 'address', 'email', 'phone', 'notes'));
        $orderInfo->order_no = $this->generateUniqueCode();
        $orderInfo->same_address = isset($request->same_address) ? 1 : 0;
        $orderInfo->payment_method = PaymentTypeEnum::from($payment_method);
        $orderInfo->tax_total_price = $summary->tax_total_price;
        $orderInfo->total_price = $summary->total_price + $summary->tax_total_price;
        $orderInfo->total_qty = $summary->total_qty;
        $orderInfo->order_status = OrderStatusEnum::ODEMEBEKLENIYOR;
        $orderInfo->user_id = Auth::user()->id;

        $request->session()->put('shoppingCart.info', $orderInfo);

        return redirect()->route('front.checkout');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateUniqueCode()
    {
        do {
            $code = random_int(10000000, 99999999);
        } while (Order::where("order_no", "=", $code)->first());

        return $code;
    }
}
