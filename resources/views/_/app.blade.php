<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | {{ $title }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('plugin/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Custom styles for this page -->
    <link href="{{ asset('plugin/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{asset('plugin/select2@4.0.13/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('plugin/datepicker-master/dist/datepicker.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('plugin/jquery-confirm@3.3.2/jquery-confirm.min.css') }}">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">
        @include('_.nav')

        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('_.head')

                @yield('content')
            </div>
            <!-- End of Main Content -->

            @include('_.footer')
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>




    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('plugin/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugin/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('plugin/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('plugin/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugin/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Select 2 -->
    <script src="{{asset('plugin/select2@4.0.13/select2.min.js')}}"></script>
    <!-- Date picker -->
    <script src="{{asset('plugin/datepicker-master/dist/datepicker.min.js')}}"></script>
    <script src="{{asset('plugin/datepicker-master/i18n/datepicker.fr-FR.js')}}"></script>
    <!-- Input mask -->
    <script src="{{asset('plugin/Inputmask-5.x/dist/jquery.inputmask.min.js')}}"></script>
    <script src="{{asset('plugin/Inputmask-5.x/dist/inputmask.min.js')}}"></script>
    <script src="{{asset('plugin/Inputmask-5.x/dist/bindings/inputmask.binding.js')}}"></script>
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

    @if ($errors->any())
        <script>
            $( document ).ready(function() {
                $.confirm({
                    title: 'Erreur!',
                    typeAnimated: true,
                    content: "Certains champs présentent des erreurs",
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
