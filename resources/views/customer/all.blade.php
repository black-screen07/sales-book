@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
      <!--a href="{{ route('user.new') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Nouvelle utilisateur</a-->
    </div>


    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered ess-dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                      <tr>
                            <th></th>
                            <th>Nom</th>
                            <th>Contacts</th>
                            <th></th>
                      </tr>
                </thead>
                <tfoot class="thead-dark">
                      <tr>
                            <th></th>
                            <th>Nom</th>
                            <th>Contacts</th>
                            <th></th>
                      </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($Customers as $key => $customer) {
                        ?>
                        <tr>
                            <td class="text-center"><i class="fas fa-user"></i></td>
                            <td>{{ $customer->fullName }}</td>
                            <td>
                                {{ $customer->phone }}
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
