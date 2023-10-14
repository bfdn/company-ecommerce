<?php

namespace App\Http\Controllers\Front;

use App\Enums\OrderStatusEnum;
use App\Events\OrderCreatedEvent;
use App\Helpers\IyzicoFormHelper;
use App\Helpers\IyzicoHelper;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use stdClass;

class CheckoutController extends Controller
{
    public function showCheckoutForm(): View
    {
        return view('front.checkout_form');
    }

    public function checkout(Request $request)
    {
        // $name = $requestLaravel->name;
        // $card_no = $requestLaravel->card_no;
        // $expire_month = $requestLaravel->expire_month;
        // $expire_year = $requestLaravel->expire_year;
        // $cvc = $requestLaravel->cvc;
        $shoppingCart = $request->session()->get('shoppingCart');
        if (!$shoppingCart) {
            // return to_route('front.cartList');
            return redirect()->route('front.cartList');
        }
        // $products = $shoppingCart['products'];
        // $summary = $shoppingCart['summary'];
        $orderInfo = $shoppingCart['info'];

        // dd($orderInfo->payment_method);

        if ($orderInfo->payment_method->name == "KAPIDAODEME") {
            $orderCreate = $this->orderCreate();
            return redirect()->route('front.checkout.result')->with(['message_type' => 'success', 'message' => 'Siparişiniz başarıyla alınmıştır.']);
        } else {

            $iyzico_helper = new IyzicoFormHelper();
            // $payment = $new_request
            //     ->createRequest($orderInfo, $total)
            //     ->getTestOptions()
            //     ->getPaymentCard($creditCard)
            //     ->getBuyer($user)
            //     ->getShippingAddress()
            //     ->getBillingAddress()
            //     ->getBasketItems($products)
            //     ->get();
            $payment = $iyzico_helper->get(Auth::user(), $shoppingCart);

            $request->session()->put('iyzico_token', $payment->getToken());
            // dd($payment);
            // dd($payment->getCheckoutFormContent());

            $page_title = "Ödeme";
            return view('front.checkout-form', compact('page_title', 'payment'));

            // işlem başarılı ise sipariş ve fatura oluştur
            /*
            if ($payment->getStatus() == "success") {
                // sipariş ve fatura oluştur
                $orderCreate = $this->orderCreate();
                return redirect()->route('front.checkout.result')->with(['message_type' => 'success', 'message' => 'Siparişiniz başarıyla oluşturuldu. Siparişiniz için teşekkür ederiz.']);
            } else {
                $errorMessage = $payment->getErrorMessage();
                return redirect()->route('front.checkout.result')->with(['message_type' => 'danger', 'message' => "Ödeme işlemi esnasında bir hata ile karşılaşıldı. <br> Lütfen girdiğiniz bilgileri ve kart limitinizi kontrol ediniz."]);
            }
            */
        }
    }

    public function checkout_son_hali_kredi_kartli(Request $request)
    {
        // $name = $requestLaravel->name;
        // $card_no = $requestLaravel->card_no;
        // $expire_month = $requestLaravel->expire_month;
        // $expire_year = $requestLaravel->expire_year;
        // $cvc = $requestLaravel->cvc;
        $shoppingCart = $request->session()->get('shoppingCart');
        // $products = $shoppingCart['products'];
        // $summary = $shoppingCart['summary'];
        $orderInfo = $shoppingCart['info'];

        // dd($orderInfo->payment_method);

        if ($orderInfo->payment_method->name == "KAPIDAODEME") {
            $orderCreate = $this->orderCreate();
            return redirect()->route('front.checkout.result')->with(['message_type' => 'success', 'message' => 'Siparişiniz başarıyla alınmıştır.']);
        } else {
            $creditCard = new stdClass();
            $creditCard->name = "Test Kullanıcı";
            $creditCard->card_no = "5526080000000006";
            $creditCard->expire_month = "09";
            $creditCard->expire_year = "30";
            $creditCard->cvc = "111";

            // Kullanıcıyı Al
            // $user = Auth::user();

            // Sepetteki ürünlerin toplam tutarını hesapla
            // $total = $summary->total_price + $summary->tax_total_price;

            $iyzico_helper = new IyzicoHelper();
            // $payment = $new_request
            //     ->createRequest($orderInfo, $total)
            //     ->getTestOptions()
            //     ->getPaymentCard($creditCard)
            //     ->getBuyer($user)
            //     ->getShippingAddress()
            //     ->getBillingAddress()
            //     ->getBasketItems($products)
            //     ->get();

            $payment = $iyzico_helper->get(Auth::user(), $shoppingCart, $creditCard);

            // işlem başarılı ise sipariş ve fatura oluştur
            if ($payment->getStatus() == "success") {
                // sipariş ve fatura oluştur
                $orderCreate = $this->orderCreate();
                return redirect()->route('front.checkout.result')->with(['message_type' => 'success', 'message' => 'Siparişiniz başarıyla oluşturuldu. Siparişiniz için teşekkür ederiz.']);
            } else {
                $errorMessage = $payment->getErrorMessage();
                return redirect()->route('front.checkout.result')->with(['message_type' => 'danger', 'message' => "Ödeme işlemi esnasında bir hata ile karşılaşıldı. <br> Lütfen girdiğiniz bilgileri ve kart limitinizi kontrol ediniz."]);
            }
        }
    }

    public function checkout_orjinal_calisan(Request $requestLaravel)
    {
        // $name = $requestLaravel->name;
        // $card_no = $requestLaravel->card_no;
        // $expire_month = $requestLaravel->expire_month;
        // $expire_year = $requestLaravel->expire_year;
        // $cvc = $requestLaravel->cvc;
        $shoppingCart = $requestLaravel->session()->get('shoppingCart');
        $products = $shoppingCart['products'];
        $summary = $shoppingCart['summary'];
        $orderInfo = $shoppingCart['info'];

        // dd($orderInfo->payment_method);

        if ($orderInfo->payment_method->name == "KAPIDAODEME") {
            $orderCreate = $this->orderCreate();
            return redirect()->route('front.checkout.result')->with(['message_type' => 'success', 'message' => 'Siparişiniz başarıyla alınmıştır.']);
        } else {
            $creditCard = new stdClass();
            $creditCard->name = "Test Kullanıcı";
            $creditCard->card_no = "5526080000000006";
            $creditCard->expire_month = "09";
            $creditCard->expire_year = "30";
            $creditCard->cvc = "111";

            // Kullanıcıyı Al
            $user = Auth::user();
            // Sepetteki ürünlerin toplam tutarını hesapla
            $total = $summary->total_price + $summary->tax_total_price;

            $options = IyzicoHelper::getTestOptions();

            // Ödeme isteği oluştur
            $request = IyzicoHelper::createRequest($orderInfo, $total);


            // PaymentCard nesnesini oluştur
            $paymentCard = IyzicoHelper::getPaymentCard($creditCard);
            $request->setPaymentCard($paymentCard);


            // Buyer nesnesini oluştur
            $buyer = IyzicoHelper::getBuyer(Auth::user());
            $request->setBuyer($buyer);

            // Kargoadresi nesnelerini oluştur
            $shippingAddress = IyzicoHelper::getShippingAddress();
            $request->setShippingAddress($shippingAddress);

            // Fatura adresi nesnelerini oluştur
            $billingAddress = IyzicoHelper::getBillingAddress();
            $request->setBillingAddress($billingAddress);


            // Sepetteki ürünleri (CartDetails) BasketItem Listesi olarak hazırla
            // $basketItems = $this->getBasketItems();
            $basketItems = IyzicoHelper::getBasketItems($products);
            $request->setBasketItems($basketItems);

            // Ödeme yap
            $payment = \Iyzipay\Model\Payment::create($request, $options);

            // işlem başarılı ise sipariş ve fatura oluştur
            if ($payment->getStatus() == "success") {
                // sipariş ve fatura oluştur
                $orderCreate = $this->orderCreate();
                return redirect()->route('front.checkout.result')->with(['message_type' => 'success', 'message' => 'Siparişiniz başarıyla oluşturuldu. Siparişiniz için teşekkür ederiz.']);
            } else {
                $errorMessage = $payment->getErrorMessage();
                return redirect()->route('front.checkout.result')->with(['message_type' => 'danger', 'message' => "Ödeme işlemi esnasında bir hata ile karşılaşıldı. <br> Lütfen girdiğiniz bilgileri ve kart limitinizi kontrol ediniz."]);
                // dd($payment);
                // dd("hata");
            }
        }
    }

    public function checkout__(Request $requestLaravel)
    {
        // $name = $requestLaravel->name;
        // $card_no = $requestLaravel->card_no;
        // $expire_month = $requestLaravel->expire_month;
        // $expire_year = $requestLaravel->expire_year;
        // $cvc = $requestLaravel->cvc;



        $shoppingCart = $requestLaravel->session()->get('shoppingCart');
        $products = $shoppingCart['products'];
        $summary = $shoppingCart['summary'];
        $orderInfo = $shoppingCart['info'];

        // dd($orderInfo->payment_method);

        if ($orderInfo->payment_method->name == "KAPIDAODEME") {
            $orderCreate = $this->orderCreate();
            return redirect()->route('front.checkout.result')->with(['message_type' => 'danger', 'message' => 'Sistemde bir hata oluştu!. Lütfen daha sonra deneyiniz']);
        } else {
            $creditCard = new stdClass();
            $creditCard->name = "Test Kullanıcı";
            $creditCard->card_no = "5526080000000006";
            $creditCard->expire_month = "09";
            $creditCard->expire_year = "30";
            $creditCard->cvc = "111";

            // Kullanıcıyı Al
            $user = Auth::user();
            // Sepetteki ürünlerin toplam tutarını hesapla
            $total = $summary->total_price + $summary->tax_total_price;



            // Options nesnesi oluştur
            // $options = new \Iyzipay\Options();
            // $options->setApiKey(env('TEST_IYZICO_API_KEY'));
            // $options->setSecretKey(env('TEST_IYZICO_SECRET_KEY'));
            // $options->setBaseUrl(env('TEST_IYZICO_BASE_URL'));
            $options = IyzicoHelper::getTestOptions();

            // Ödeme isteği oluştur
            // $request = new \Iyzipay\Request\CreatePaymentRequest();
            // $request->setLocale(\Iyzipay\Model\Locale::TR);
            // $request->setConversationId($orderInfo->order_no); // herhangi bir sayı verilebilir, unique bir değer vermek mantıklı olabilir
            // $request->setPrice($total);
            // $request->setPaidPrice($total);
            // $request->setCurrency(\Iyzipay\Model\Currency::TL);
            // $request->setInstallment(1); // Taksit olayı
            // $request->setBasketId("B67832"); // sepet id
            // $request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
            // $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
            $request = IyzicoHelper::createRequest($orderInfo, $total);


            // PaymentCard nesnesini oluştur
            $paymentCard = IyzicoHelper::getPaymentCard($creditCard);
            // $paymentCard = new \Iyzipay\Model\PaymentCard();
            // $paymentCard->setCardHolderName($name);
            // $paymentCard->setCardNumber($card_no);
            // $paymentCard->setExpireMonth($expire_month);
            // $paymentCard->setExpireYear($expire_year);
            // $paymentCard->setCvc($cvc);
            // $paymentCard->setRegisterCard(0); // Kartı kaydedip kaydetmeyeceği soruluyor
            // $request->setPaymentCard($paymentCard);
            $request->setPaymentCard($paymentCard);


            // Buyer nesnesini oluştur
            // $buyer = new \Iyzipay\Model\Buyer();
            // $buyer->setId($user->id);
            // $buyer->setName($user->name);
            // $buyer->setSurname($user->name);
            // $buyer->setGsmNumber("+905350000000");
            // $buyer->setEmail($user->email);
            // $buyer->setIdentityNumber("74300864791"); // TC no
            // $buyer->setLastLoginDate("2015-10-05 12:43:35");
            // $buyer->setRegistrationDate("2013-04-21 15:12:09");
            // // $buyer->setRegistrationAddress($orderInfo->address);
            // $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
            // // $buyer->setIp("85.34.78.112");
            // $buyer->setIp($requestLaravel->ip());
            // $buyer->setCity("Istanbul");
            // $buyer->setCountry("Turkey");
            // $buyer->setZipCode("34732");
            $buyer = IyzicoHelper::getBuyer(Auth::user());
            $request->setBuyer($buyer);

            // Kargoadresi nesnelerini oluştur
            // $shippingAddress = new \Iyzipay\Model\Address();
            // $shippingAddress->setContactName("Jane Doe");
            // $shippingAddress->setCity("Istanbul");
            // $shippingAddress->setCountry("Turkey");
            // $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
            // $shippingAddress->setZipCode("34742");
            $shippingAddress = IyzicoHelper::getShippingAddress();
            $request->setShippingAddress($shippingAddress);

            // Fatura adresi nesnelerini oluştur
            // $billingAddress = new \Iyzipay\Model\Address();
            // $billingAddress->setContactName("Jane Doe");
            // $billingAddress->setCity("Istanbul");
            // $billingAddress->setCountry("Turkey");
            // $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
            // $billingAddress->setZipCode("34742");
            $billingAddress = IyzicoHelper::getBillingAddress();
            $request->setBillingAddress($billingAddress);


            // Sepetteki ürünleri (CartDetails) BasketItem Listesi olarak hazırla
            // $basketItems = array();

            // $thirdBasketItem = new \Iyzipay\Model\BasketItem();
            // $thirdBasketItem->setId("BI103");
            // $thirdBasketItem->setName("Usb");
            // $thirdBasketItem->setCategory1("Electronics");
            // $thirdBasketItem->setCategory2("Usb / Cable");
            // $thirdBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            // $thirdBasketItem->setPrice("0.2");
            // $basketItems[2] = $thirdBasketItem;
            $basketItems = $this->getBasketItems();
            $request->setBasketItems($basketItems);

            // Ödeme yap
            $payment = \Iyzipay\Model\Payment::create($request, $options);

            // işlem başarılı ise sipariş ve fatura oluştur
            if ($payment->getStatus() == "success") {
                // sipariş ve fatura oluştur
                $orderCreate = $this->orderCreate();
                return redirect()->route('front.checkout.result')->with(['message_type' => 'danger', 'message' => 'Sistemde bir hata oluştu!. Lütfen daha sonra deneyiniz']);
            } else {
                return redirect()->route('front.checkout.result')->with(['message_type' => 'danger', 'message' => 'Sistemde bir hata oluştu!. Lütfen daha sonra deneyiniz']);
                // dd($payment);
                // dd("hata");
            }
        }
    }

    public function getBasketItems()
    {
        $shoppingCart = request()->session()->get('shoppingCart');
        $products = $shoppingCart['products'];

        $basketItems = array();

        foreach ($products as $product) {
            $item = new \Iyzipay\Model\BasketItem();
            $item->setId($product->id);
            $item->setName($product->name);
            $item->setCategory1("Electronics");
            // $item->setCategory2("Usb / Cable");
            $item->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            $item->setPrice($product->price + $product->tax_price);

            // Arr::add($basketItems, $item);
            for ($i = 0; $i < $product->qty; $i++) {
                array_push($basketItems, $item);
            }
        }

        return $basketItems;
    }

    public function orderCreate()
    {
        $shoppingCart = request()->session()->get('shoppingCart');
        $products = $shoppingCart['products'];
        $summary = $shoppingCart['summary'];
        $orderInfo = $shoppingCart['info'];


        try {
            $orderInfo->save();
        } catch (\Throwable $th) {
            return redirect()->route('front.cartList')->with(['message_type' => 'danger', 'message' => 'Sistemde bir hata oluştu!. Lütfen daha sonra deneyiniz'])->withInput();
        }

        try {
            foreach ($products as $product) {
                $orderDetail = new OrderDetail();
                // $orderDetail->fill();
                $orderDetail->order_id = $orderInfo->id;
                $orderDetail->product_id = $product->id;
                $orderDetail->price = $product->price;
                $orderDetail->qty = $product->qty;
                $orderDetail->total_price = $product->total_price + $product->tax_price;
                $orderDetail->tax = $product->tax;
                $orderDetail->tax_price = $product->tax_price;
                // $orderDetail->order_detail_status = OrderStatusEnum::from("ONAYBEKLIYOR");
                $orderDetail->order_detail_status = OrderStatusEnum::ONAYBEKLIYOR;
                $orderDetail->save();
            }
        } catch (\Throwable $th) {
            return redirect()->route('front.cartList')->with(['message_type' => 'danger', 'message' => 'Sistemde bir hata oluştu!. Lütfen daha sonra deneyiniz'])->withInput();
        }

        event(new OrderCreatedEvent(Auth::user(), $orderInfo));

        request()->session()->forget("shoppingCart");


        return true;
    }

    public function checkoutResult__()
    {
        $page_title = "Sipariş Sonuç";
        return view('front.checkout-result', compact('page_title'));
    }

    public function checkoutResult()
    {
        $shoppingCart = request()->session()->get('shoppingCart');
        if (!$shoppingCart) {
            return redirect()->route('front.cartList');
        }
        $iyzico_token = request()->session()->get('iyzico_token');

        $orderInfo = $shoppingCart['info'];


        $iyzico_helper = new IyzicoFormHelper();

        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId($orderInfo->order_no);
        $request->setToken($iyzico_token);

        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $iyzico_helper->getTestOptionsNew());

        session()->regenerate();

        if ($checkoutForm->getStatus() == "success") {
            // sipariş ve fatura oluştur
            $orderCreate = $this->orderCreate();
            request()->session()->forget("iyzico_token");
            // return redirect()->route('front.checkout.result')->with(['message_type' => 'success', 'message' => 'Siparişiniz başarıyla oluşturuldu. Siparişiniz için teşekkür ederiz.']);
            $sonuc = ['message_type' => 'success', 'message' => 'Siparişiniz başarıyla oluşturuldu. Siparişiniz için teşekkür ederiz.'];
        } else {
            $errorMessage = $checkoutForm->getErrorMessage();
            // return redirect()->route('front.checkout.result')->with(['message_type' => 'danger', 'message' => "Ödeme işlemi esnasında bir hata ile karşılaşıldı. <br> Lütfen girdiğiniz bilgileri ve kart limitinizi kontrol ediniz."]);
            $sonuc = ['message_type' => 'danger', 'message' => "Ödeme işlemi esnasında bir hata ile karşılaşıldı. <br> Lütfen girdiğiniz bilgileri ve kart limitinizi kontrol ediniz. <br> " . $errorMessage];
        }

        $page_title = "Sipariş Sonuç";
        return view('front.checkout-result', compact('page_title'))->with('sonuc', $sonuc);
    }
}
