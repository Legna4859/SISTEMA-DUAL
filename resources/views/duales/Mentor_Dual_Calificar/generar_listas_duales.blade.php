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
    <h3>PROFESOR: {{  $profesor->titulo." ".$profesor->nombre }}</h3>
    <h3>MES: _________________________________________________________</h3>
</h6>

<div class="col-md-12 col-xs-10 col-md-offset-1">
    <div class="panel">
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr style="text-align: center">
                    <th style="text-align: center"><strong>No. Cuenta</strong></th>
                    <th style="text-align: center"><strong>Nombre del Alumno Dual</strong></th>
                    <th style="text-align: center"><strong>Asistencia</strong></th>
                    <th style="text-align: center"><strong>Observaciones</strong></th>
                </tr>
                </thead>
                <tbody>
                @foreach($datos_registros as $dato_registro)
                    <tr>
                        <td style="text-align: center">{{$dato_registro->cuenta}}</td>
                        <td style="text-align: center">{{$dato_registro->nombre." ".$dato_registro->apaterno." ".$dato_registro->amaterno}}</td>
                        <td style="text-align: center">
                            <label for="asistencia-si_1" style="text-align: center">Sí</label>
                            <input type="radio" name="asistencia_1" value="si" id="asistencia-si_1" class="text-center">

                            <label for="asistencia-no_1" style="text-align: center">No</label>
                            <input type="radio" name="asistencia_1" value="no" id="asistencia-no_1" class="text-center">
                        </td>
                        <td style="text-align: center"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <hr style="text-align:center;margin-top:10%;width: 50%">
        <h6 style="text-align:center;margin-top:0%;font-size: 9pt">{{  $profesor->titulo." ".$profesor->nombre }}</h6>
    </div>
</div>
</body>
</html>
<style>
    body {
        font-family: 'Times New Roman', serif;
    }

    img {
        width: 30%;
        margin-left: 35%;
    }

    h5 {
        font-family: 'Times New Roman', serif;
        text-align: center;
        background: #AAB7B8;
        margin-top: 1%;
    }
    h3,h6 {
        font-family: 'Times New Roman', serif;
        text-align: left;
    }

    table {
        font-family: 'Times New Roman', serif;
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        font-family: 'Times New Roman', serif;
        border: 1px solid #ccc;
        text-align: center;
        padding: 8px;
        font-size: 10pt;
    }

    th {
        background-color: #AAB7B8;
    }

    label {
    cursor: pointer;
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: white;
    border: 1px solid black;
    margin-right: 5px; /* Añade margen a la derecha para separar del texto */
}

input[type="radio"] {
    display: none;
}

input[type="radio"]:checked + label {
    background-color: #2ecc71;
}


input[type="radio"] {
    display: none;
}

/* Añade margen a la derecha del texto */
label + input[type="radio"] {
    margin-left: 5px; /* Puedes ajustar el margen según sea necesario */
}

</style>
