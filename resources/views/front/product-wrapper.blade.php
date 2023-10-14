<!-- Desktop Version  -->
<div class="row shop__product-items">

    @foreach ($products as $product)
        <div class="col-xl-4 col-md-6">
            <x-front.product-item :product="$product" class="cards-md--four w-100" />
        </div>
    @endforeach

</div>

{{ $products->onEachside(0)->links('front.paginate') }}
