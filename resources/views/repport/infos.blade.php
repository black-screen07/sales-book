@extends('_.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>

    <div class="row mt-4">
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group mb-0">
                                    <select class="form-control ess-select2" name="yearSelected" >
                                        <?php
                                        for ($year=config('global.sartYear'); $year<=intval(date('Y')) ; $year++) {
                                            ?>
                                            <option value="{{ $year }}"
                                                {{ $yearSelected==$year ? 'selected="selected"' : "" }}
                                                >
                                                {{ $year }}
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group mb-0">
                                    <select class="form-control ess-select2" name="monthSelected" >
                                        <?php
                                        foreach (config('global.month') as $key => $month) {
                                            ?>
                                            <option value="{{ $key }}"
                                                {{ $monthSelected==$key ? 'selected="selected"' : "" }}
                                                >
                                                {{ $month }}
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <button type="submit" class="btn btn-primary btn-md btn-icon-split float-right">
                                    <span class="icon text-gray-600">
                                    <i class="fas fa-search"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md">
            <div class="card bg-info text-white shadow h-100 py-2">
                <div class="card-body">
                    <a href="{{ route('sale.all') }}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: rgba(255,255,255,.8)!important;">
                                Ventes
                            </div>
                            <div class="h3 mb-0 font-weight-bold ">
                                {{ currencyFormat($SalesAmount) }}
                                <small>{{ config('global.currence') }}</small>
                            </div>
                            </div>
                            <div class="col-auto">
                            <i class="fab fa-product-hunt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="card bg-danger text-white shadow h-100 py-2">
                <div class="card-body">
                    <a href="{{ route('supplying.all') }}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: rgba(255,255,255,.8)!important;">
                                Approvisionnements
                            </div>
                            <div class="h3 mb-0 font-weight-bold ">
                                {{ currencyFormat($Supplyings->sum('price')) }}
                                <small>{{ config('global.currence') }}</small>
                            </div>
                            </div>
                            <div class="col-auto">
                            <i class="fas fa-cart-plus fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="card bg-danger text-white shadow h-100 py-2">
                <div class="card-body">
                    <a href="{{ route('chargeCost.all') }}">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: rgba(255,255,255,.8)!important;">
                                Charges
                            </div>
                            <div class="h3 mb-0 font-weight-bold ">
                                {{ currencyFormat($ChargeCosts->sum('amount')) }}
                                <small>{{ config('global.currence') }}</small>
                            </div>
                            </div>
                            <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="text-center mb-0">
                        {{ currencyFormat($SalesAmount - $Supplyings->sum('price') - $ChargeCosts->sum('amount')) }} <small>{{ config('global.currence') }}</small>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample_" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample_">
                    <h6 class="m-0 font-weight-bold text-primary">Vente par catégorie</h6>
                </a>
                <div class="collapse show" id="collapseCardExample_" style="">
                    <div class="card-body" style="height: 300px !important; overflow-y: auto;">
                        @foreach ($categories as $category)
                            @php
                                $percent = round(($category['qte']*100) / $categories->sum('qte'), 2);
                            @endphp
                            <h4 class="small font-weight-bold">{{ isset($category['cat']->name) ? $category['cat']->name : $category['cat'] }} ({{ $category['qte'] }} produit{{ s($category['qte']) }})<span class="float-right">{{ $percent }}%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
              </div>
        </div>
        <div class="col-md">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Vente par produits</h6>
                </a>
                <div class="collapse show" id="collapseCardExample" style="">
                    <div class="card-body" style="height: 300px !important; overflow-y: auto;">
                        @foreach ($products as $product)
                            @php
                                $percent = round(($product['qte']*100) / $products->sum('qte'), 2);
                            @endphp
                            <h4 class="small font-weight-bold">{{ $product['prod']->name }} ({{ $product['qte'] }})<span class="float-right">{{ $percent }}%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
