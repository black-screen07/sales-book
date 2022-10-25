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
                    <form action="" method="post" class=" mb-0">
                        @csrf
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control ess-is-required ess-datepicker" name="startDate" value="{{ date('d/m/Y', strtotime($startDate)) }}"
                                    data-inputmask="'mask': '99/99/9999'" data-msg="Veuiller renseigner la date de debut">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control ess-is-required ess-datepicker" name="endDate" value="{{ date('d/m/Y', strtotime($endDate)) }}"
                                    data-inputmask="'mask': '99/99/9999'" data-msg="Veuiller renseigner la date de fin">
                                </div>
                            </div>
                            <div class="col-md-2">
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
                        <th class="text-center">Heure</th>
                        <th class="text-center">Produit(s)</th>
                        <th class="text-center">Coût <sup>{{ config('global.currence') }}</sup></th>
                        <th class="text-center">Dû <sup>{{ config('global.currence') }}</sup></th>
                        <th class="text-center">Client</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot class="thead-dark">
                      <tr>
                        <th class="text-center">Heure</th>
                        <th class="text-center">Produit(s)</th>
                        <th class="text-center">Coût <sup>{{ config('global.currence') }}</sup></th>
                        <th class="text-center">Dû <sup>{{ config('global.currence') }}</sup></th>
                        <th class="text-center">Client</th>
                        <th></th>
                      </tr>
                </tfoot>

                <tbody>
                    <?php
                    foreach ($Sales as $key => $Sale) {
                        ?>
                        <tr>
                            <td class="text-center">
                                {{ date('d/m/Y H:i', strtotime($Sale->dateS)) }}
                            </td>
                            <td class="text-center">
                                @foreach ($Sale->products as $sp)
                                    <span class="badge badge-light">{{ $sp->name }} <small>x</small>{{ $sp->pivot->qte }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">{{ currencyFormat($Sale->tt) }}</td>
                            <td class="text-center">{{ ($Sale->tt - $Sale->cash) > 0 ? currencyFormat($Sale->tt - $Sale->cash) : "" }}</td>
                            <td class="text-center">{{ $Sale->customer!=null ? $Sale->customer->fullName.' #'.$Sale->customer->phone : "" }}</td>
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
@endsection
