@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>


    <div class="row">
        <div class="col-md">
            <div class="card shadow mb-0">
                <div class="card-body">
                    <div class="form-group mb-4">
                        <select class="form-control ess-select2 saleAddProduct" name="productId" data-content="{{ route('sale.product.modal', ['']) }}">
                            <option value="">AJOUTER UN PRODUIT</option>
                            <?php
                            foreach ($Products as $key => $Product) {
                                ?>
                                <option value="{{ $Product->id }}">
                                    {{ $Product->name }} {{ $Product->hasStock() ? '('.$Product->qte.')' : '' }} #{{ $Product->price }} {{ config('global.currence') }}
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <table class="table">
                        @php
                            $tt = 0;
                        @endphp
                        @if (Session::has('sale'))
                            @foreach (Session::get('sale') as $product)
                                <tr>
                                    <td>
                                        <a class="img float-left" style="background-image: url('{{ $product->getImg() }}');"></a>
                                        <span class="ml-2">
                                            <b class="text-dark">{{ $product->name }}</b>
                                            <br>
                                            <small class="ml-2">{{ $product->category ? $product->category->name : '' }}</small>
                                        </span>
                                    </td>
                                    <td class="">
                                        {{ currencyFormat($product->price) }}

                                        <span class="badge badge-dark">x {{ $product->saleQte }}</span>
                                        <br>
                                        <b class="text-dark">
                                            {{ currencyFormat($product->price * $product->saleQte ) }} <small>{{ config('global.currence') }}</small>
                                        </b>
                                    </td>
                                    <td class="text-center" width="100">
                                        <button type="button" class="btn btn-warning btn-circle btn-sm mr-2 saleEditProduct"
                                        data-id="{{ $product->id }}" data-content="{{ route('sale.product.modal', ['']) }}">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <a href="{{ route('sale.product.remove', ["productId"=>$product->id]) }}" class="btn btn-danger btn-circle btn-sm ess-link-checked"
                                            data-msg="Souhaitez-vous retirer le produit?">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @php
                                    $tt += ($product->price * $product->saleQte);
                                @endphp
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>

        @if (Session::has('sale'))
        <div class="col-md-5">
            <div class="card bg-primary text-white shadow mb-4">
                <div class="card-body">
                    <table>
                        <tr>
                            <th class="text-left">
                                <h4 class="text-white">TOTAL</h4>
                            </th>
                            <th class="text-right">
                                <h4 class="text-white">{{ currencyFormat($tt) }} <small>{{ config('global.currence') }}</small></h4>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-left">
                            </th>
                            <th class="text-right">
                                <span class="badge badge-dark change">Dû : {{ currencyFormat($tt) }} <small>{{ config('global.currence') }}</small></span>
                            </th>
                        </tr>
                    </table>
                </div>
            </div>
            <form class="form-new-sale" autocomplete="off" method="POST" action="{{ route('sale.new') }}">
                @csrf
                <input type="hidden" id="sate-new-tt" name="tt" value="{{ $tt }}">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group row mb-0">
                          <label for="" class="col-sm-4 col-form-label">Montant versé</label>
                          <div class="col-sm">
                            <input type="number" class="form-control ess-is-required cash" id="sale-new-cash"  min="0" value="" name="cash" data-tt="{{ $tt }}"
                            data-msg="Veuillez renseigner le montant">
                          </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">Nom du client</label>
                          <div class="col-sm">
                            <input type="text" class="form-control" name="fullName" id="sale-new-fullName">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-4 col-form-label">Téléphone du client</label>
                          <div class="col-sm">
                            <input type="text" data-inputmask="'mask': '99 99 99 99 99'" class="form-control" name="phone" id="sale-new-phone">
                          </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Client existant</label>
                            <select class="form-control ess-select2 exitCat" name="customerId"  id="sale-new-customerId">
                                <option value="">---</option>
                                <?php
                                foreach ($Customers as $key => $Customer) {
                                    ?>
                                    <option value="{{ $Customer->id }}"
                                        {{ Request::old('customerId')==$Customer->id ? 'selected="selected"' : "" }}
                                        >
                                        {{ $Customer->fullName }} #{{ $Customer->phone }}
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <br>

                        <button type="submit" class="btn btn-primary btn-sm btn-icon-split mt-1">
                            <span class="icon text-gray-600">
                              <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">Enregistrer</span>
                      </button>
                      <a href="{{ route('sale.cancel') }}" class="btn btn-danger btn-sm btn-icon-split mt-1 float-right ess-link-checked"
                        data-msg="Souhaitez-vous annuler la vente?">
                            <span class="icon text-gray-600">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Annuler</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        @endif
    </div>


    @if (!Session::has('sale'))
        <div class="card shadow mb-4 mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $Sales->count() }} dernières ventes de la journée</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="height: 170px !important; overflow-y: auto;">
                    <table class="table ess-table-header-fixed" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">Heure</th>
                                    <th class="text-center">Produit(s)</th>
                                    <th class="text-center">Coût <sup>{{ config('global.currence') }}</sup></th>
                                    <th class="text-center">Dû <sup>{{ config('global.currence') }}</sup></th>
                                    <th class="text-center">Client</th>
                                </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($Sales as $key => $Sale) {
                                ?>
                                <tr>
                                    <td class="text-center">
                                        {{ date('H:i', strtotime($Sale->dateS)) }}
                                    </td>
                                    <td class="text-center">
                                        @foreach ($Sale->products as $sp)
                                            <span class="badge badge-light">{{ $sp->name }} <small>x</small>{{ $sp->pivot->qte }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">{{ currencyFormat($Sale->tt) }}</td>
                                    <td class="text-center">{{ ($Sale->tt - $Sale->cash) >0 ? currencyFormat($Sale->tt - $Sale->cash) : "" }}</td>
                                    <td class="text-center">{{ $Sale->customer!=null ? $Sale->customer->fullName.' '.$Sale->customer->phone : "" }}</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection

