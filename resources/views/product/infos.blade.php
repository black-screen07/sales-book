@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
      <a href="{{ route('product.all') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i></a>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <a class="img" style="background-image: url('{{ $Product->getImg() }}'); width:100%; height:200px;"></a>
                </div>
                <div class="col-md">
                    <form class="ess-form-checked" autocomplete="off" method="post" action="{{ route('product.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="productId" value="{{ $Product->id }}">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Catégorie</label>
                                    <select class="form-control ess-select2 exitCat" name="categoryId" >
                                        <option value="">---</option>
                                        <?php
                                        foreach ($categories as $key => $category) {
                                            ?>
                                            <option value="{{ $category->id }}"
                                                {{ $Product->categoryId==$category->id ? 'selected="selected"' : "" }}
                                                >
                                                {{ $category->name }}
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label>Nouvelle Catégorie</label>
                                    <input type="text" class="form-control newCat" name="categoryNew" value="{{Request::old('categoryNew')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nom du produit *</label>
                            <input type="text" class="form-control ess-is-required" name="name"
                            data-msg="Veuiller renseigner le nom du produit" value="{{ $Product->name }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Produit avec stock *</label>
                            <select class="form-control ess-select2 " name="hasStock">
                                <option value="1"
                                    {{ $Product->hasStock()==TRUE ? 'selected="selected"' : "" }}>
                                    Oui
                                </option>
                                <option value="0"
                                    {{ $Product->hasStock()==FALSE ? 'selected="selected"' : "" }}>
                                    Non
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantité du produit</label>
                            <input type="number" class="form-control" name="qte" value="{{ $Product->qte }}">
                        </div>
                        <div class="form-group">
                            <label>Prix du produit *</label>
                            <input type="number" class="form-control ess-is-required" name="price"
                            data-msg="Veuiller renseigner le price du produit" value="{{ $Product->price }}">
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="form-control" name="img">
                        </div>

                        <div><small>* Obligatoire</small></div>

                        <button type="submit" class="btn btn-warning btn-sm btn-icon-split mt-2">
                            <span class="icon text-gray-600">
                              <i class="fas fa-pen"></i>
                            </span>
                            <span class="text">Modifier</span>
                      </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

