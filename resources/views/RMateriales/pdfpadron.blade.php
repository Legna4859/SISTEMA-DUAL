<!DOCTYPE html>
<html lang="en">
<head class="header_fijo" style="">
    <meta charset="UTF-8">
    <title>Padrón general del TESVB</title>
</head>
<body>
<header class="header_fijo">
    <img align="right" src="img/edomex3.png" >
    <img align="right" src="img/logo.png">
    <img align="left" src="img/edom1.png" >
</header>
<br>
<section>
    <div>
        <h3 style="color: black; text-align: center"  >Padrón General de Bienes Patrimoniales del TESVB</h3>

        <h4 id="depa">Módulo Inventario:</h4>
        <!--estructura $variable del controlador referenciando al  modelo -> nombre de la funcion en el modelo con la FK
         ->nombre de otra funcion del modelo-> columna de la tabla del dato que se solicita -->
    </div>
    <div id="maintable">
        <h3 >Bienes Patrimoniales</h3>

        <table class="mitabla" cellspacing="0">
            <thead>
            <tr>
                <th>Departamento</th>
                <th>Resguardatario:</th>
                <th>Puesto:</th>
                <th>Nombre del Bien:</th>
                <th>Fecha de Resguardo:</th>
                <th>Estado del Bien:</th>
            </tr>
            </thead>
            <tbody align="center">

            <tr>
                <td><br></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @foreach($resguardos as $res)
                @foreach($res->bienes as $bien)
                    @foreach($res->sectores as $sector)
            <tr>
                <td style="background-color: whitesmoke">{{$sector->departamentos->nom_departamento}}</td>
                <td>{{$sector->nombre}}</td>
                <td style="background-color: whitesmoke">{{$sector->puesto}}</td>
                <td>{{$bien->nombre}}</td>
                <td style="background-color: whitesmoke">{{$res->fecha}}</td>
                <td>@if($bien-> condicion == 1)
                        <span class="text-success">Activo</span>
                    @else
                        <span class="text-danger">Desactivado</span>
                    @endif
                </td>
            </tr>
                    @endforeach
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
    <br>
</section>

<style>

    body {
        margin: 2cm -4cm 2cm;
    }

    header {
        position: fixed;
        top: -1cm;
        left: -1cm;
        right: -1cm;
        height: 2.5cm;
        background-color: white;
        text-align: center;
        line-height: 30px;
        margin: 1cm 1cm 2cm;

    }

    footer {
        position: fixed;
        bottom: 0cm;
        left: -1cm;
        right: -1cm;
        height: 2.5cm;

        color: black;
        text-align: center;
        line-height: 35px;

    }
    logo1
    {

        width: 100%;
    }
    section{text-align: center;}
    #maintable{width: 80%; text-align: center;margin: auto 10%;}
    #depa{width: 80%; text-align: left;margin: auto 12%;}


    .mitabla{width: 100%; padding:20px;}
    .mitabla thead{background-color: lightgray;}
</style>

<footer>
    <img align="left" src="img/footer1.png" >

</footer>
</body>


</html>