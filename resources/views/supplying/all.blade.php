@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
      <a href="{{ route('supplying.new') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Nouvelle Approvisionement</a>
    </div>


    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered ess-dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                      <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Fournisseur</th>
                        <th class="text-center">Nb de Produits</th>
                        <th class="text-center">N° BL</th>
                        <th class="text-center">Coût</th>
                        <th></th>
                      </tr>
                </thead>
                <tfoot class="thead-dark">
                      <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Fournisseur</th>
                        <th class="text-center">Nb de Produits</th>
                        <th class="text-center">N° BL</th>
                        <th class="text-center">Coût</th>
                        <th></th>
                      </tr>
                </tfoot>

                <tbody>
                    <?php
                    foreach ($Supplyings as $key => $Supplying) {
                        ?>
                        <tr>
                            <td class="text-center">{{ date('d/m/Y', strtotime($Supplying->dateS)) }}</td>
                            <td class="text-center">{{ $Supplying->supplier ? $Supplying->supplier->fullName : "" }}</td>
                            <td class="text-center">{{ $Supplying->products->count() }}</td>
                            <td class="text-center">{{ $Supplying->deliverySheetCode }}</td>
                            <td class="text-center">{{ currencyFormat($Supplying->price) }}</td>
                            <td class="text-center">
                                <a href="{{ route('supplying.infos', [$Supplying->id]) }}" class="btn btn-warning btn-circle btn-sm">
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
