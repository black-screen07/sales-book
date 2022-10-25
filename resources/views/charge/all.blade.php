@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
      <a href="{{ route('chargeCost.new') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Nouvelle Charge</a>
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
                                        <option value="all">Tous les mois</option>
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


    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered ess-dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                      <tr>
                        <th class="text-center">Mois & Année</th>
                        <th class="text-center">Désignation</th>
                        <th class="text-center">Montant <sup>{{ config('global.currence') }}</sup></th>
                        <th></th>
                      </tr>
                </thead>
                <tfoot class="thead-dark">
                      <tr>
                        <th class="text-center">Mois & Année</th>
                        <th class="text-center">Désignation</th>
                        <th class="text-center">Montant <sup>{{ config('global.currence') }}</sup></th>
                        <th></th>
                      </tr>
                </tfoot>

                <tbody>
                    <?php
                    foreach ($ChargeCosts as $key => $ChargeCost) {
                        ?>
                        <tr>
                            <td class="text-center">{{ config('global.month.'.$ChargeCost->month) }} {{ $ChargeCost->year }}</td>
                            <td class="text-center">{{ $ChargeCost->charge->name }}</td>
                            <td class="text-center">{{ currencyFormat($ChargeCost->amount) }}</td>
                            <td class="text-center">
                                <a href="{{ route('chargeCost.infos', [$ChargeCost->id]) }}" class="btn btn-warning btn-circle btn-sm mr-2">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('chargeCost.remove', ["chargeCostId"=>$ChargeCost->id]) }}" class="btn btn-danger btn-circle btn-sm ess-link-checked"
                                    data-msg="Souhaitez-vous retirer la charge?">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <h3 class="text-center">
            <hr>
            Total :
            {{ currencyFormat($ChargeCosts->sum('amount')) }}
            <small>{{ config('global.currence') }}</small>
        </h3>
      </div>
    </div>

</div>
@endsection
