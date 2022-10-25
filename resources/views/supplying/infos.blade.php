@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
      <a href="{{ route('supplying.all') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i></a>
    </div>

    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample" class="d-block card-header collapsed py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ date('d/m/Y', strtotime($Supplying->dateS)) }}
                {{ $Supplying->supplier ? " | ".$Supplying->supplier->fullName : "" }}
            </h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse" id="collapseCardExample">
            <div class="card-body">
                <form class="ess-form-checked" autocomplete="off" method="post" action="{{ route('supplying.update') }}">
                    @csrf
                    <input type="hidden" name="supplyingId" value="{{ $Supplying->id }}">
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Fournisseur</label>
                                <select class="form-control ess-select22 exitCat" name="supplierId" >
                                    <option value="">---</option>
                                    <?php
                                    foreach ($Suppliers as $key => $supplier) {
                                        ?>
                                        <option value="{{ $supplier->id }}"
                                            {{ $Supplying->supplierId==$supplier->id ? 'selected="selected"' : "" }}
                                            >
                                            {{ $supplier->fullName }}
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label>Nouvelle Fournisseur</label>
                                <input type="text" class="form-control newCat" name="supplierNew" value="{{Request::old('supplierNew')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label>N° du bon de livraison</label>
                                <input type="text" class="form-control" name="deliverySheetCode" value="{{ $Supplying->deliverySheetCode }}">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label>Date *</label>
                                <input type="text" class="form-control ess-is-required ess-datepicker" name="dateS" value="{{ date('d/m/Y', strtotime($Supplying->dateS)) }}"
                                data-inputmask="'mask': '99/99/9999'" data-msg="Veuiller renseigner la date">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Coût total</label>
                                <input type="number" class="form-control ess-is-required" name="price" value="{{ $Supplying->price }}" data-msg="Veuiller renseigner le coût">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Commentaire</label>
                        <textarea name="comment" class="form-control" rows="3">{{ $Supplying->comment }}</textarea>
                    </div>

                    <div><small>* Obligatoire</small></div>

                    <button type="submit" class="btn btn-primary btn-sm btn-icon-split mt-4">
                        <span class="icon text-gray-600">
                        <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text">Modifier</span>
                    </button>
                </form>
            </div>
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body">
            @foreach ($Supplying->products->sortBy('name') as $product)
                <form class="ess-form-checked" action="{{ route('supplying.product.update') }}" method="POST" autocomplete="off">
                    <div class="row">
                        @csrf
                        <input type="hidden" name="supplyingId" value="{{ $Supplying->id }}">
                        <input type="hidden" name="productId" value="{{ $product->id }}">
                        <input type="hidden" name="currentQte" value="{{ $product->pivot->qte }}">
                        <div class="col-md">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control ess-is-required" name="qte"
                                disabled value="{{ $product->name }}">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group mb-0">
                                <input type="number" class="form-control ess-is-required text-center" name="qte"
                                data-msg="Veuiller renseigner la quantité" value="{{ $product->pivot->qte }}">
                            </div>
                        </div>
                        <div class="col-md-3 text-center mt-1">
                            <button type="submit" class="btn btn-warning btn-circle btn-sm mr-2">
                                <i class="fas fa-pen"></i>
                            </button>
                            <a href="{{ route('supplying.product.remove', ["supplyingId"=>$Supplying->id, "productId"=>$product->id, "qte"=>$product->pivot->qte]) }}" class="btn btn-danger btn-circle btn-sm ess-link-checked"
                                data-msg="Souhaitez-vous retirer le produit?">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </form>
                <hr>
            @endforeach
            <strong>TOTAL PRODUIT : {{ $Supplying->products->count() }}</strong>
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ajoute de produit</h6>
        </div>
        <div class="card-body">
            <form class="ess-form-checked" action="{{ route('supplying.product.add') }}" method="POST" autocomplete="off">
                <div class="row">
                    @csrf
                    <input type="hidden" name="supplyingId" value="{{ $Supplying->id }}">
                    <div class="col-md">
                        <label>Produit</label>
                        <select name="productId" class="form-control ess-select2 ess-is-required"
                        data-msg="Veuiller selectionner le produit">
                            <option value="">---</option>
                            @foreach ($Products as $Product)
                                @if ($Product->hasStock())
                                <option value="{{ $Product->id }}">{{ $Product->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label>Quantité</label>
                            <input type="number" class="form-control ess-is-required" name="qte"
                            data-msg="Veuiller renseigner la quantité">
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button style="submit" class="btn btn-primary btn-sm btn-icon-split">
                            <span class="icon text-gray-600">
                              <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">Ajouter</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

