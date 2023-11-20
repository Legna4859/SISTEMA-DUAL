<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista PDF Alumnos Duales</title>
</head>

<body>
<img src="img/tes.PNG" alt="">
<h5>LISTA DE ASISTENCIA ALUMNOS DUALES</h5>

<h6 style="margin-top: 20px">
    <h3>PROFESOR: {{  $profesor->titulo }} {{  $profesor->nombre }}</h3>
</h6>

<div class="col-md-12 col-xs-10 col-md-offset-1">
    <div class="panel">
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th><strong>No. Cuenta</strong></th>
                    <th><strong>Nombre del Alumno Dual</strong></th>
                </tr>
                </thead>
                <tbody>
                @foreach($datos_registros as $dato_registro)
                    <tr>
                        <td>{{$dato_registro->cuenta}}</td>
                        <td>{{$dato_registro->nombre." ".$dato_registro->apaterno." ".$dato_registro->amaterno}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <hr style="text-align:center;margin-top:10%;width: 50%">
        <h6 style="text-align:center;margin-top:0%;font-size: 9pt">{{  $profesor->titulo }} {{  $profesor->nombre }}</h6>
    </div>
</div>
</body>
</html>
<style>
    body {
        font-family: serif, "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    img {
        width: 30%;
        margin-left: 35%;
    }

    h5 {
        font-family: serif, "Helvetica Neue", Helvetica, Arial, sans-serif;
        text-align: center;
        background: #2ab27b;
        margin-top: 1%;
    }
    h3,h6 {
        font-family: serif, "Helvetica Neue", Helvetica, Arial, sans-serif;
        text-align: left;
    }

    table {
        font-family: serif, "Helvetica Neue", Helvetica, Arial, sans-serif;
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        font-family: serif, "Helvetica Neue", Helvetica, Arial, sans-serif;
        border: 1px solid #ccc;
        text-align: center;
        padding: 8px;
        font-size: 10pt;
    }

    th {
        background-color: #2ab27b;
    }

</style>
