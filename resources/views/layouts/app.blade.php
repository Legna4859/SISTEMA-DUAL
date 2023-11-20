<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="/js/jquery.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" integrity="sha384-vhJnz1OVIdLktyixHY4Uk3OHEwdQqPppqYR8+5mjsauETgLOcEynD9oPHhhz18Nw" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- Datepicker Files -->
    <link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker.standalone.css')}}">
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
    <link href="{{ asset('open-iconic-master/font/css/open-iconic-bootstrap.css') }}" rel="stylesheet" >

    <script type="application/javascript" src="/js/jquery-ui.js"></script>




    <script type="application/javascript" src="/js/tooltip.js"></script>




    <script src="{{asset('datepicker/js/bootstrap-datepicker.js')}}"></script>

    <!-- Languaje -->

    <script src="{{asset('datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>

    <!-- filtros para color picker -->
    <script src="/js/bootstrap-colorpicker.js"></script>

    <!-- switch toggle -->
    <script src="/js/bootstrap-toggle.js"></script>
    <link href="/css/bootstrap-toggle.css" rel="stylesheet">
    <link href="/css/timepicker.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/themes/default.css">
    <link rel="stylesheet" href="/css/themes/default.time.css">

    {{--sweet alert--}}
    <script src="{{asset('js/sweetalert.js')}}"></script>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/bootstrap-colorpicker.css" rel="stylesheet">
    <link href="/css/jquery.timepicker.css" rel="stylesheet">


{{--    <link rel="stylesheet" href="/css/jquery-ui.js">--}}


    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    {{--
   <script src="/js/app.js"></script>
--}}
{{--    <script src="/js/jquery.timepicker.js"></script>--}}
    <script src="/js/validate.min.js"></script>
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/accent-neutralise.js"></script>
    <script src="/js/dataTables.fixedHeader.min.js"></script>
    <script src="/js/jquery.blockUI.js"></script>
    <script src="/js/dataTables.bootstrap.min.js"></script>
    <script src="/js/highcharts.js"></script>
    <script src="/js/modules/exporting.js"></script>
		<script src="{{asset('js/sweetalert2.min.js')}}"></script>
        <script type="text/javascript">
        $('#nav').affix({
            offset: {
                top: $('header').height()
            }
        });

        $('#sidebar').affix({
            offset: {
                top: 200
            }
        });


    </script>


    {{--///////////////////////////////////////////////////////////--}}




    <script src="/js/picker.js"></script>
    <script src="/js/picker.time.js"></script>
    <script src="/js/legacy.js"></script>
</head>

<body >


@section('header')
@include('partials.head')
@show



    @section('menu')
        @if (Auth::guest())
            @include('partials.menu_register')
        @else
            @include('partials.menu_admin')

        @endif
    @show


    @section('part_modal_periodos')
         @if (!Auth::guest())
                @include('partials.periodos')
        @endif
    @show

@yield('content')

@section('footer')
@include('partials.footer')
@show

    <!-- Scripts -->



</body>
</html>
