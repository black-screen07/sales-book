@extends('_.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>

    <div class="row">
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Catégorie de produits</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="height: 300px !important; overflow-y: auto;">
                        <table class="table ess-table-header-fixed" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                    <tr>
                                        <th class="text-left">Nom</th>
                                        <th class="text-right"></th>
                                    </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($Categories as $key => $Category) {
                                    ?>
                                    <form action="{{ route('config.category.update') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="categoryId" value="{{ $Category->id }}">
                                        <tr>
                                            <td class="text-left">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" name="name" value="{{ $Category->name }}">
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="submit" class="btn btn-warning btn-circle btn-sm mr-2">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                                <a href="{{ route('config.category.delete', ["categoryId"=>$Category->id]) }}" class="btn btn-danger btn-circle btn-sm ess-link-checked"
                                                    data-msg="Souhaitez-vous suprimer la catégorie?">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </form>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Charges</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="height: 300px !important; overflow-y: auto;">
                        <table class="table ess-table-header-fixed" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                    <tr>
                                        <th class="text-left">Nom</th>
                                        <th class="text-right"></th>
                                    </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($Charges as $key => $charge) {
                                    ?>
                                    <form action="{{ route('config.charge.update') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="chargeId" value="{{ $charge->id }}">
                                        <tr>
                                            <td class="text-left">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" name="name" value="{{ $charge->name }}">
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="submit" class="btn btn-warning btn-circle btn-sm mr-2">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                                <a href="{{ route('config.charge.delete', ["chargeId"=>$charge->id]) }}" class="btn btn-danger btn-circle btn-sm ess-link-checked"
                                                    data-msg="Souhaitez-vous suprimer la catégorie?">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </form>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Charges</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="height: 300px !important; overflow-y: auto;">
                        <table class="table ess-table-header-fixed" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                    <tr>
                                        <th class="text-left">Nom</th>
                                        <th class="text-left">Téléphone</th>
                                        <th class="text-right"></th>
                                    </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($Customers as $key => $customer) {
                                    ?>
                                    <form action="{{ route('config.customer.update') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="customerId" value="{{ $customer->id }}">
                                        <tr>
                                            <td class="text-left">
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" name="fullName" value="{{ $customer->fullName }}">
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <div class="form-group mb-0">
                                                    <input type="text" data-inputmask="'mask': '99 99 99 99'" class="form-control" name="phone" value="{{ $customer->phone }}">
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="submit" class="btn btn-warning btn-circle btn-sm mr-2">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                                <a href="{{ route('config.customer.delete', ["customerId"=>$customer->id]) }}" class="btn btn-danger btn-circle btn-sm ess-link-checked"
                                                    data-msg="Souhaitez-vous suprimer la catégorie?">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </form>
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
