@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
      <a href="{{ route('product.new') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Nouveau {{ config('global.product') }}</a>
    </div>


    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered ess-dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                      <tr>
                            <th></th>
                            <th>Nom</th>
                            <th class="text-center">Prix <sup>{{ config('global.currence') }}</sup></th>
                            <th>Catégorie</th>
                            @if (config('global.hasQte'))
                                <th class="text-center">Qte en stock</th>
                            @endif
                            <th></th>
                      </tr>
                </thead>
                <tfoot class="thead-dark">
                      <tr>
                            <th></th>
                            <th>Nom</th>
                            <th class="text-center">Prix <sup>{{ config('global.currence') }}</sup></th>
                            <th>Catégorie</th>
                            @if (config('global.hasQte'))
                                <th class="text-center">Qte en stock</th>
                            @endif
                            <th></th>
                      </tr>
                </tfoot>

                <tbody>
                    <?php
                    foreach ($products as $key => $product) {
                        ?>
                        <tr>
                            <td class="text-center"><a class="img" style="background-image: url('{{ $product->getImg() }}');"></a></td>
                            <td><?= $product->name ?></td>
                            <td class="text-center">{{ currencyFormat($product->price) }}</td>
                            <td>{{ $product->category ? $product->category->name : '' }}</td>
                            @if (config('global.hasQte'))
                                <td class="text-center">{{ $product->hasStock() ? $product->qte : '--' }}</td>
                            @endif
                            <td class="text-center">
                                <a href="{{ route('product.infos', [$product->id]) }}" class="btn btn-warning btn-circle btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>


</div>
@endsection
