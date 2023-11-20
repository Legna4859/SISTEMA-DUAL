<!DOCTYPE html>
<html lang="en">
<head class="header_fijo" style="">
    <meta charset="UTF-8">
    <title>Tarjeta de Resguardo de: {{$resguardos->sector->nombre}}</title>
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
            <h4 style="color: black; text-align: center"  >Registro de Patrimonio tarjeta de Resguardo</h4>

            <h4 id="mainfecha">Fecha de Resguardo: {{$resguardos->fecha}}</h4>
            <h4 id="depa">Departamento: {{$resguardos->sector->departamentos->nom_departamento}} </h4>
            <!--estructura $variable del controlador referenciando al  modelo -> nombre de la funcion en el modelo con la FK
             ->nombre de otra funcion del modelo-> columna de la tabla del dato que se solicita -->
            <h4 id="sec">Resguardatario: {{$resguardos->sector->nombre}} </h4>
            <h4 id="puesto">Puesto: {{$resguardos->sector->puesto}} </h4>
        </div>
        <div id="maintable">
            <h3 >Bien Asignado</h3>

            <table class="mitabla" cellspacing="0">
                <thead>
                <tr>
                    <th>Bien:</th>
                    <th>Categoría:</th>
                    <th>Caracteristicas del Bien:</th>
                    <th>Número de Inventario:</th>
                    <th>Nic:</th>
                    <th>No. Factura:</th>
                    <th>No.Serie:</th>
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
                <tr>
                    <td>{{$resguardos->bien->nombre}}</td>
                    <td>{{$resguardos->bien->categorias->nombre}}</td>
                    <td>{{$resguardos->bien->caracteristicas}}
                    {{$resguardos->bien->modelos->modelo}}
                    {{$resguardos->bien->marcas->marca}}
                    {{$resguardos->bien->provedores->nombre}}</td>
                    <td>{{$resguardos->bien->num_inventario}}</td>
                    <td>{{$resguardos->bien->nick}}</td>
                    <td>{{$resguardos->bien->factura}}</td>
                    <td>{{$resguardos->bien->serie}}</td>
                </tr>
                </tbody>

            </table>
        </div>
        <br>
        <div class="form-control">
            <h4 id="nom">Nombre y Firma del Resguardatario:</h4><h4 id="nom1">Nombre y Firma de responsable del Activo Fijo:</h4><br>
            <h4 id="firma">_________________________________</h4>      <h4 id="firma1">_____________________________</h4>
        </div>
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
    #mainfecha{width: 80%; text-align: left;margin: auto 70%;}
    #depa{width: 80%; text-align: left;margin: auto 12%;}
    #sec{width: 80%; text-align: left;margin: auto 12%;}
    #puesto{width: 80%; text-align: left;margin: auto 12%;}
    #nom{width: 80%; text-align: left;margin: auto 20%;}
    #firma{width: 80%; text-align: left;margin: auto 20%;}
    #nom1{width: 80%; text-align: left;margin: auto 60%;}
    #firma1{width: 80%; text-align: left;margin: auto 60%;}

    .mitabla{width: 100%; padding:20px;}
    .mitabla thead{background-color: lightgray;}
    .mitabla tfoot{background-color: antiquewhite;}
    .mitabla td {background-color: #F9F9F9}
</style>

<footer>
    <img align="left" src="img/footer1.png" >

</footer>
</body>


</html>