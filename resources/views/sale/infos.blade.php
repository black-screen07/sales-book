@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>


    <div class="row">
        <div class="col-md">
            <div class="card shadow mb-0">
                <div class="card-body">
                    <table class="table">
                        @foreach ($Sale->products as $product)
                            <tr>
                                <td>
                                    <a class="img float-left" style="background-image: url('{{ $product->getImg() }}');"></a>
                                    <span class="ml-2">
                                        <b class="text-dark">{{ $product->name }}</b>
                                        <br>
                                        <small class="ml-2">{{ $product->category ? $product->category->name : '' }}</small>
                                    </span>
                                </td>
                                <td class="">
                                    {{ currencyFormat($product->pivot->price) }}
                                    <span class="badge badge-dark">x {{ $product->pivot->qte }}</span>
                                </td>
                                <td class="text-right">
                                    <b class="text-dark">
                                        {{ currencyFormat($product->pivot->price * $product->pivot->qte ) }} <small>{{ config('global.currence') }}</small>
                                    </b>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-primary text-white shadow mb-4">
                <div class="card-body">
                    <table>
                        <tr>
                            <th class="text-left">
                                <h4 class="text-white">TOTAL ACHAT</h4>
                            </th>
                            <th class="text-right">
                                <h4 class="text-white">{{ currencyFormat($Sale->tt) }} <small>{{ config('global.currence') }}</small></h4>
                            </th>
                        </tr>
                        @php
                            $du = $Sale->tt - $Sale->cash;
                        @endphp
                        <tr>
                            <th class="text-left">
                                <h4 class="text-white">RESTE</h4>
                            </th>
                            <th class="text-right">
                                <h4 class="text-white">{{ $du>0 ? currencyFormat($du) : "0" }} <small>{{ config('global.currence') }}</small></h4>
                            </th>
                        </tr>
                        @if ($du>0)
                            <tr>
                                <th class="text-left">
                                </th>
                                <th class="text-right">
                                    <span class="badge badge-dark change">Dû : {{ currencyFormat($du) }} <small>{{ config('global.currence') }}</small></span>
                                </th>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            <form class="ess-form-checked" autocomplete="off" method="POST" action="{{ route('sale.update') }}">
                @csrf
                <input type="hidden" name="saleId" value="{{ $Sale->id }}">
                <input type="hidden" name="tt" value="{{ $du }}">
                @if ($du>0)
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="form-group row mb-0">
                            <label for="" class="col-sm-4 col-form-label">Montant versé</label>
                            <div class="col-sm">
                                <input type="number" class="form-control ess-is-required cash"  min="0" value="" name="cash" data-tt="{{ $du }}"
                                data-msg="Veuillez renseigner le montant">
                            </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card shadow mb-4">
                    <div class="card-body">
                        @if ($Sale->customer)
                        <p>
                            <b>Client : </b> {{ $Sale->customer ? $Sale->customer->fullName." #".$Sale->customer->phone : "" }}
                        </p>
                        <hr>
                        @endif

                        @if ($du>0)
                        <button type="submit" class="btn btn-primary btn-sm btn-icon-split mt-1">
                            <span class="icon text-gray-600">
                              <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">Enregistrer</span>
                        </button>
                        @endif
                        <a href="{{ route('sale.remove', ["saleId"=>$Sale->id]) }}" class="btn btn-danger btn-sm btn-icon-split mt-1 float-right ess-link-checked"
                        data-msg="Souhaitez-vous suprimer la vente?">
                            <span class="icon text-gray-600">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Suprimer la vente</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

