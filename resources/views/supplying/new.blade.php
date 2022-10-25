@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
      <a href="{{ route('supplying.all') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i></a>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="ess-form-checked" autocomplete="off" method="post" action="{{ route('supplying.new') }}">
                @csrf
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Fournisseur</label>
                            <select class="form-control ess-select2 exitCat" name="supplierId" >
                                <option value="">---</option>
                                <?php
                                foreach ($Suppliers as $key => $supplier) {
                                    ?>
                                    <option value="{{ $supplier->id }}"
                                        {{ Request::old('supplierId')==$supplier->id ? 'selected="selected"' : "" }}
                                        >
                                        {{ $supplier->name }}
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
                <div class="form-group">
                    <label>N° du bon de livraison</label>
                    <input type="text" class="form-control" name="deliverySheetCode">
                </div>
                <div class="form-group">
                    <label>Date *</label>
                    <input type="text" class="form-control ess-is-required ess-datepicker" name="dateS"
                    data-inputmask="'mask': '99/99/9999'" data-msg="Veuiller renseigner la date">
                </div>
                <div class="form-group">
                    <label>Coût total *</label>
                    <input type="number" class="form-control ess-is-required" name="price" data-msg="Veuiller renseigner le coût">
                </div>
                <div class="form-group">
                    <label>Commentaire</label>
                    <textarea name="comment" class="form-control" rows="3"></textarea>
                </div>

                <div><small>* Obligatoire</small></div>

                <button type="submit" class="btn btn-primary btn-sm btn-icon-split mt-4">
                    <span class="icon text-gray-600">
                      <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">Enregistrer Les Produits</span>
              </button>
            </form>
        </div>
    </div>

</div>
@endsection

