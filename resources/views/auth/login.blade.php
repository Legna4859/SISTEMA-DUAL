@extends('layouts.app')
@section('title', 'Login TESVB')
@section('content')
<div class="container" id="container">
    <div class="row">
       
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif


<div id="modal_guia" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            
            <div class="item active col">
                    <img src="img/1.png">
              
              <div class="text-center" style="color:black;">
                <strong><h3>Si no eres usuario registrado. Dar clic en el botón Registro ubicado en la parte superior derecha.</h3></strong>
              </div>
          </br>
            </div>
              
          


            <div class="item">
              <img src="img/2.png" >
              <div class="" style="color:black;">
                <strong><h3>En el formulario de registro deberás ingresar tu correo que será tu identificación de usuario, contraseña y el tipo de usuario.</h3></strong>
              </div>
            </div>
            <div class="item">
              <img src="img/3.png" >
              <div class="" style="color:black;">
                <strong><h3>El sistema enviará un enlace de autentificación al correo que haya sido registrado con la finalidad de verificar que el usuario registrado exista.</h3></strong>
              </div>
            </div>
                        <div class="item">
              <img src="img/4.png" >
              <div class="carousel-caption" style="color:black;">
                <strong><h3> Una vez que accedas a tu correo,selecciona el link, dar clic derecho y abrir el enlace en una nueva pestaña.</h3></strong>
              </div>
            </div>
                                    <div class="item">
              <img src="img/5.png" >
              <div class="" style="color:black;">
               <strong><h3>  Dependiendo del tipo de usuario que haya seleccionado en el registro aparecerá un formulario, el cuál se deberá llenar con los datos respectivos.</h3></strong>
              </div>
            </div>
            <div class="item">
              <img src="img/6.png" >
              <div class="" style="color:black;">
                <strong><h3>En caso de que haya seleccionado el tipo de usuario Empleado y haya concluido el registro 
                   solo se podra tener acceso al menu una vez que sea asignado(a) como docente.</h3></strong>
              </div>
            </div>
          </div>

          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Iniciar Sesión</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        <!-- action="{{ url('/login') }}"  -->
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo Electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Entrar
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <p style="text-align: center;color: #0c0c0c"><b>AVISO DE PRIVACIDAD</b></p>
<br>
                    <p>El Tecnológico de Estudios Superiores de Valle de Bravo, comprometido con la protección de datos personales,
                        prohíbe la distribución de información que se pudiera generar o recabar durante el uso del Sistema de Gestión Institucional,
                        sin previo aviso a los titulares de los datos personales guardados dentro de este último.</p>
<br>
                    <p >Usted puede conocer los términos y alcances de nuestros Avisos de Privacidad Integral en:</p>
                    <h3 style="text-align: center; "><a href="http://tesvb.edomex.gob.mx/proteccion-datos-personales">http://tesvb.edomex.gob.mx/proteccion-datos-personales</a>
                        </h3>

                </div>

            </div>
        </div>
    </div>
</div>


@endsection
