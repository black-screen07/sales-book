
<div class="content-fluid">
    <div class="row">
        <div class="col-md">
            <a class="img" style="background-image: url('{{ $Product->getImg() }}'); width:100%; height:200px;"></a>
        </div>
        <div class="col-md">
            <h5>{{ $Product->name }}</h5>
            <p>
                {{ currencyFormat($Product->price) }} <small>{{ config('global.currence') }}</small>
                @if ($Product->hasStock())
                <br>
                {{ $Product->qte }} en stock
                @endif
            </p>
            <form class="form-sale-product" autocomplete="off" method="post" action="{{ route('sale.product.add') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="productId" value="{{ $Product->id }}">
                <div class="form-group mt-3">
                    <input type="number" class="form-control sale-product-qte" name="qte" value="{{ $saleQte }}"
                    data-qte="{{ $Product->hasStock() ? $Product->qte : 99999999999 }}">
                </div>
            </form>
        </div>
    </div>
</div>
