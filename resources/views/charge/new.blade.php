@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
      <a href="{{ route('chargeCost.all') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i></a>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="ess-form-checked" autocomplete="off" method="post" action="{{ route('chargeCost.new') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Charge</label>
                            <select class="form-control ess-select2 exitCat" name="chargeId" >
                                <option value="">---</option>
                                <?php
                                foreach ($Charges as $key => $charge) {
                                    ?>
                                    <option value="{{ $charge->id }}"
                                        {{ Request::old('chargeId')==$charge->id ? 'selected="selected"' : "" }}
                                        >
                                        {{ $charge->name }}
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-group">
                            <label>Nouvelle Charge</label>
                            <input type="text" class="form-control newCat" name="chargeNew" value="{{Request::old('chargeNew')}}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Année *</label>
                    <select class="form-control ess-select2 ess-is-required" name="year" data-msg="Veuiller renseigner l'année">
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

                <div class="form-group">
                    <label>Mois *</label>
                    <select class="form-control ess-select2 ess-is-required" name="month" data-msg="Veuiller renseigner le mois">
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
                <div class="form-group">
                    <label>Montant *</label>
                    <input type="number" class="form-control ess-is-required" name="amount"
                    data-msg="Veuiller renseigner le montant" value="{{Request::old('amount')}}">
                </div>

                <div><small>* Obligatoire</small></div>

                <button type="submit" class="btn btn-primary btn-sm btn-icon-split mt-4">
                    <span class="icon text-gray-600">
                      <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">Enregistrer</span>
              </button>
            </form>
        </div>
    </div>

</div>
@endsection

