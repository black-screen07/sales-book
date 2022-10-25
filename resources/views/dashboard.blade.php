@extends('_.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
      <a href="{{ route('sale.new') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
        <i class="fas fa-money-bill-wave fa-sm text-white-50"></i> Caisse</a>
    </div>


    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ventes de la journée</div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ currencyFormat($SalesAmount) }} <small>{{ config('global.currence') }}</small></div>
                        </div>
                    </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ config('global.products') }}</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $products->count() }}</div>
                </div>
                <div class="col-auto">
                <i class="fab fa-product-hunt fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ config('global.products') }} en stock</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $products->sum('qte') }}</div>
                </div>
                <div class="col-auto">
                <i class="fas fa-cart-plus fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>

        <!-- Pending Requests Card Example
        <div class="col-md mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Approvisionnement</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $Supplyings->count() }}</div>
                </div>
                <div class="col-auto">
                <i class="fas fa-cart-arrow-down fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>-->
    </div>

    <div class="row">
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ventes de la journée</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="height: 300px !important; overflow-y: auto;">
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
        </div>
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Stock critique (inférieur à 20)</h6>
                </div>
                <div class="card-body">
                <div class="table-responsive" style="height: 300px !important; overflow-y: auto;">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <tbody>
                            @foreach ($products->where('qte', '<', 20)->where('hasStock', '=', 1) as $product)
                            <tr>
                                <td>
                                    <a class="img float-left" style="background-image: url('{{ $product->getImg() }}');"></a>
                                    <span class="ml-2">
                                        <b class="text-dark">{{ $product->name }}</b>
                                        <br>
                                        <small class="ml-2">{{ $product->category ? $product->category->name : '' }}</small>
                                    </span>
                                </td>
                                <td class="text-right">
                                    <span class="badge badge-dark">{{ $product->qte }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>


        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Crédits</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="height: 300px !important; overflow-y: auto;">
                        <table class="table ess-table-header-fixed" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">Heure</th>
                                        <th class="text-center">Produit(s)</th>
                                        <th class="text-center">Coût <sup>{{ config('global.currence') }}</sup></th>
                                        <th class="text-center">Dû <sup>{{ config('global.currence') }}</sup></th>
                                        <th class="text-center">Client</th>
                                        <th></th>
                                    </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($SalesOwning as $key => $Sale) {
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            {{ date('H:i', strtotime($Sale->dateS)) }}
                                        </td>
                                        <td class="text-center">{{ $Sale->products->count() }}</td>
                                        <td class="text-center">
                                            @foreach ($Sale->products as $sp)
                                                <span class="badge badge-light">{{ $sp->name }} <small>x</small>{{ $sp->pivot->qte }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">{{ ($Sale->tt - $Sale->cash) > 0 ? currencyFormat($Sale->tt - $Sale->cash) : "" }}</td>
                                        <td class="text-center">{{ $Sale->customer ? $Sale->customer->fullName.' '.$Sale->customer->phone : "" }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('sale.infos', [$Sale->id]) }}" class="btn btn-warning btn-circle btn-sm">
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
    </div>
</div>
@endsection
