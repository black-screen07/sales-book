@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
      <a href="{{ route('user.new') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Nouvelle utilisateur</a>
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
                            <th class="text-center">Type</th>
                            <th class="text-center">Etat</th>
                            <th></th>
                      </tr>
                </thead>
                <tfoot class="thead-dark">
                      <tr>
                            <th></th>
                            <th>Nom</th>
                            <th>Contacts</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Etat</th>
                            <th></th>
                      </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($Users as $key => $user) {
                        ?>
                        <tr>
                            <td class="text-center"><a class="img" style="background-image: url('{{ $user->getImg() }}');"></a></td>
                            <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                            <td>
                                {{ $user->email }}
                                <?= $user->phone ? "<br>#".$user->phone : "" ?>
                            </td>
                            <td class="text-center">{{ $user->level->name }}</td>
                            <td class="text-center">
                                @if ($user->enabled==1)
                                <span class="badge badge-light">Actif</span>
                                @else
                                <span class="badge badge-danger">Désactivé</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('user.infos', [$user->id]) }}" class="btn btn-warning btn-circle btn-sm">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('user.remove', ["userId"=>$user->id]) }}" class="btn btn-danger btn-circle btn-sm ess-link-checked"
                                    data-msg="Souhaitez-vous suprimer définitivement ce utilisateur ({{ $user->firstname }} {{ $user->lastname }})">
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
      </div>
    </div>


</div>
@endsection
