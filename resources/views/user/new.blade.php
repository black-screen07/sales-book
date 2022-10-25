@extends('_.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
      <a href="{{ route('user.all') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i></a>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="ess-form-checked" autocomplete="off" method="post" action="{{ route('user.new') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Type</label>
                            <select class="form-control ess-select2 ess-is-required" name="userLevelCode"
                            data-msg="Veuiller selectionner le type">
                                <option value="">---</option>
                                <?php
                                foreach ($UserLevels as $key => $userLevel) {
                                    ?>
                                    <option value="{{ $userLevel->code }}"
                                        {{ Request::old('userLevelCode')==$userLevel->code ? 'selected="selected"' : "" }}
                                        >
                                        {{ $userLevel->name }}
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nom *</label>
                    <input type="text" class="form-control ess-is-required" name="firstname"
                    data-msg="Veuiller renseigner le nom" value="{{Request::old('firstname')}}">
                </div>
                <div class="form-group">
                    <label>Prénom *</label>
                    <input type="text" class="form-control ess-is-required" name="lastname"
                    data-msg="Veuiller renseigner le prénom" value="{{Request::old('lastname')}}">
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="text" class="form-control ess-is-required ess-inputmask-email" name="email"
                    data-msg="Veuiller renseigner l'adresse mail" value="{{Request::old('email')}}">
                </div>
                <div class="form-group">
                    <label>Téléphone </label>
                    <input type="text" data-inputmask="'mask': '99 99 99 99'" class="form-control" name="phone"
                    value="{{Request::old('phone')}}">
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="form-control" name="img">
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

