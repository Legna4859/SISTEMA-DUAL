<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h1>Lista de articulos</h1>

    <table id="tabla_envio" class="table table-bordered table-resposive">
            <thead>
                <tr class="text-center">
                    <th class="text-center">artiulos</th>
                </tr>
                <tr>
                    <th>
                    @foreach($articulos as $articulo)
                <option value="{{$articulo->id_articulo}}" data-art="{{$articulo->nombre_articulo}}"> {{$articulo->nombre_articulo}} </option>
                @endforeach
                    </th>
                </tr>
            </thead>
        </table>
</body>
</html>


