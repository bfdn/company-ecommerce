<?php

namespace App\Helpers;

use Iyzipay\Options;
use Iyzipay\Request\CreatePaymentRequest;

class IyzicoFormHelper
{
    private $request;
    private $options;
    private $paymentCard;
    private $buyer;
    private $shippingAddress;
    private $billingAddress;
    private $basketItems;
    // private $item;

    public function __construct()
    {
        $this->request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
    }

    public function createRequest($orderInfo, float $finalPrice)
    {
        // Ödeme isteği oluştur
        $this->request->setLocale(\Iyzipay\Model\Locale::TR);
        $this->request->setConversationId($orderInfo->order_no);
        $this->request->setPrice($finalPrice);
        $this->request->setPaidPrice($finalPrice);
        $this->request->setCurrency(\Iyzipay\Model\Currency::TL);
        $this->request->setBasketId("B67832");
        $this->request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $this->request->setCallbackUrl("http://127.0.0.1:8000/tr/odeme/sonuc");
        $this->request->setEnabledInstallments(array(2, 3, 6, 9));

        return $this;
    }

    public function getPaymentCard($creditCard)
    {
        $this->paymentCard = new \Iyzipay\Model\PaymentCard();
        $this->paymentCard->setCardHolderName($creditCard->name);
        $this->paymentCard->setCardNumber($creditCard->card_no);
        $this->paymentCard->setExpireMonth($creditCard->expire_month);
        $this->paymentCard->setExpireYear($creditCard->expire_year);
        $this->paymentCard->setCvc($creditCard->cvc);
        $this->paymentCard->setRegisterCard(0); // Kartı kaydedip kaydetmeyeceği soruluyor

        $this->request->setPaymentCard($this->paymentCard);
        // return $paymentCard;
        return $this;
    }

    public function getBuyer($user)
    {
        $this->buyer = new \Iyzipay\Model\Buyer();
        $this->buyer->setId($user->id);
        $this->buyer->setName($user->name);
        $this->buyer->setSurname($user->name);
        $this->buyer->setGsmNumber("+905350000000");
        $this->buyer->setEmail($user->email);
        $this->buyer->setIdentityNumber("74300864791"); // TC no
        $this->buyer->setLastLoginDate("2015-10-05 12:43:35");
        $this->buyer->setRegistrationDate("2013-04-21 15:12:09");
        // $buyer->setRegistrationAddress($orderInfo->address);
        $this->buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        // $buyer->setIp("85.34.78.112");
        $this->buyer->setIp(request()->ip());
        $this->buyer->setCity("Istanbul");
        $this->buyer->setCountry("Turkey");
        $this->buyer->setZipCode("34732");

        $this->request->setBuyer($this->buyer);
        return $this;
    }

    public function getShippingAddress()
    {
        $this->shippingAddress = new \Iyzipay\Model\Address();
        $this->shippingAddress->setContactName("Jane Doe");
        $this->shippingAddress->setCity("Istanbul");
        $this->shippingAddress->setCountry("Turkey");
        $this->shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $this->shippingAddress->setZipCode("34742");
        $this->request->setShippingAddress($this->shippingAddress);
        return $this;
    }

    public function getBillingAddress()
    {
        $this->billingAddress = new \Iyzipay\Model\Address();
        $this->billingAddress->setContactName("Jane Doe");
        $this->billingAddress->setCity("Istanbul");
        $this->billingAddress->setCountry("Turkey");
        $this->billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $this->billingAddress->setZipCode("34742");
        $this->request->setBillingAddress($this->billingAddress);
        return $this;
    }

    public function getBasketItems($products)
    {
        $this->basketItems = array();

        foreach ($products as $product) {
            $item = new \Iyzipay\Model\BasketItem();
            $item->setId($product->id);
            $item->setName($product->name);
            $item->setCategory1("Electronics");
            // $item->setCategory2("Usb / Cable");
            $item->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            // $this->item->setPrice($product->price + $product->tax_price);
            $item->setPrice($product->price + ($product->price / 100 * $product->tax->value));

            // Arr::add($basketItems, $item);
            for ($i = 0; $i < $product->qty; $i++) {
                array_push($this->basketItems, $item);
            }
        }
        $this->request->setBasketItems($this->basketItems);
        return $this;
    }

    public function getTestOptions()
    {
        $this->options = new \Iyzipay\Options();
        $this->options->setApiKey(env('TEST_IYZICO_API_KEY'));
        $this->options->setSecretKey(env('TEST_IYZICO_SECRET_KEY'));
        $this->options->setBaseUrl(env('TEST_IYZICO_BASE_URL'));

        return $this;
    }

    public function getTestOptionsNew()
    {
        $this->options = new \Iyzipay\Options();
        $this->options->setApiKey(env('TEST_IYZICO_API_KEY'));
        $this->options->setSecretKey(env('TEST_IYZICO_SECRET_KEY'));
        $this->options->setBaseUrl(env('TEST_IYZICO_BASE_URL'));

        return $this->options;
    }

    public function getProductionOptions()
    {
        $this->options = new \Iyzipay\Options();
        $this->options->setApiKey(env('IYZICO_API_KEY'));
        $this->options->setSecretKey(env('IYZICO_SECRET_KEY'));
        $this->options->setBaseUrl(env('IYZICO_BASE_URL'));

        // return $options;
        return $this;
    }


    public function get__()
    {
        return \Iyzipay\Model\Payment::create($this->request, $this->options);
    }

    public function get($user, $shoppingCart)
    {
        $products = $shoppingCart['products'];
        $summary = $shoppingCart['summary'];
        $orderInfo = $shoppingCart['info'];

        $total = $summary->total_price + $summary->tax_total_price;

        $this->createRequest($orderInfo, $total)
            ->getTestOptions()
            // ->getPaymentCard($creditCard)
            ->getBuyer($user)
            ->getShippingAddress()
            ->getBillingAddress()
            ->getBasketItems($products);

        // return \Iyzipay\Model\CheckoutFormInitialize::create($this->request, Config::options());;
        return \Iyzipay\Model\CheckoutFormInitialize::create($this->request, $this->options);
    }
}
