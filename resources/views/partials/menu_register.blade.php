@section('menu')
<nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                       TESVB
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                 
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Registro</a></li>
                            <li> <a class="link parpadea" data-toggle="tooltip" data-placement="top" title ="Ayuda Registro"><span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="font-size: 18px; text-decoration: blink;"></span></a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <script>
  $(document).ready(function(){
$(".link").tooltip({html:true});

$(".link").click(function(){

  $("#modal_guia").modal("show");
});
    
    });

</script>
@endsection