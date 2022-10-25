<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('plugin/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugin/jquery-confirm@3.3.2/jquery-confirm.min.css') }}">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

</head>

<body class="" style="background-color: #f2f3f7;">
    <br><br><br><br>

    <div class="container">

      <!-- Outer Row -->
      <div class="row justify-content-center eee">
          <div class="col-xl-10 col-lg-12 col-md-9">
          <div class="card o-hidden border-0 shadow-lg my-5">
              <div class="card-body p-0">
              <!-- Nested Row within Card Body -->
              <div class="row">
                  <div class="col-lg-6 d-none d-lg-block bg-login-image"
                  style="background-image: url('{{ asset('img/magasin.jpg') }}');">
                      <div class="text-center p-5 m-5">
                          {{-- <img class="img" src="{{ $Company ? $Company->getLogo() : '' }}" alt=""> --}}
                      </div>
                  </div>
                  <div class="col-lg-6">
                  <div class="p-5">
                      <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">{{ config('global.name') }}</h1>
                      </div>
                      <form class="user ess-form-checked" autocomplete="off" action="{{ route('login') }}" method="POST">
                          @csrf
                          <div class="form-group">
                              <input type="text" class="form-control form-control-user ess-is-required" name="username" placeholder="E-mail..."
                              data-msg="Veuiller renseigner votre email">
                          </div>
                          <div class="form-group">
                              <input type="password" class="form-control form-control-user ess-is-required" name="password" placeholder="Mot de passe..."
                              data-msg="Veuiller renseigner votre mot de passe">
                          </div>
                          <div class="form-group">
                              <div class="custom-control custom-checkbox small">
                              <input type="checkbox" class="custom-control-input" id="customCheck">
                              <label class="custom-control-label" for="customCheck">Restez connecter</label>
                              </div>
                          </div>
                          <button type="submit" class="btn btn-primary btn-user btn-block">
                              Se Connecter
                          </button>
                      </form>
                  </div>
                  </div>
              </div>
              </div>
          </div>
      </div><!-- Footer -->
      <footer class="sticky-footer">
          <div class="container my-auto">
              <div class="copyright text-center my-auto">
              <span>Copyright Egnin Aka &copy; Développer par <a href="{{ config('global.ownerLink') }}" target="_blank">{{ config('global.owner') }}</a> </span>
              </div>
          </div>
      </footer>
      <!-- End of Footer -->


      </div>

    </div>




  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('plugin/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugin/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('plugin/jquery-easing/jquery.easing.min.js') }}"></script>
  <!-- Jquery confirm -->
  <script src="{{ asset('plugin/jquery-confirm@3.3.2/jquery-confirm.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/script.js') }}"></script>


  @if(Session::has('ess-msg'))
  <script>
      $( document ).ready(function() {
          $.confirm({
              title: 'Message!',
              typeAnimated: true,
              content: "<?= Session::get('ess-msg') ?>",
              buttons: {
                  somethingElse: {
                      text: 'Fermer',
                      action: function(){
                      }
                  }
              }
          });
      });
  </script>
@endif

</body>

</html>
