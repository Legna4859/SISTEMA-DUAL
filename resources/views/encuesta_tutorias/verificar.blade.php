@if($registrar_residencia == true and $anteproyecto_aceptado == false)
    <li>
        <a href="{{url('/residencia/registrar_anteproyecto')}}">Registrar
            Anteproyecto</a></li>
    <li>
        <a href="{{url('/residencia/correcciones_anteproyecto/')}}">Correciones
            anteproyecto</a></li>
@elseif($registrar_residencia == false and $anteproyecto_aceptado == false)

    <li>
        <a href="{{url('/residencia/correcciones_anteproyecto/')}}">Correciones
            anteproyecto</a></li>

@elseif($anteproyecto_aceptado == true and $registrar_residencia == true)
    <li>
        <a href="{{url('/residencia/correcciones_anteproyecto/')}}">Correciones
            anteproyecto</a></li>
    <li><a href="{{url('/residencia/agregar_empresa')}}">Agregar
            empresa</a></li>
    @if($registro_empresa == true)
        <li><a href="#"  onclick="window.open('{{url('/residencia/dictamen_anteproyecto')}}')">Dictamen  Anteproyecto</a></li>
        <li style=""><a href="{{url('/residencia/documentos_alta_residencia')}}">Enviar documentos de alta de residencia</a></li>
    @endif
@elseif($anteproyecto_aceptado == true and $registrar_residencia == false)
    <li>
        <a href="{{url('/residencia/correcciones_anteproyecto/')}}">Correciones
            anteproyecto</a></li>
    <li><a href="{{url('/residencia/agregar_empresa')}}">Agregar
            empresa</a></li>
    @if($registro_empresa == true)
        <li><a href="#"
               onclick="window.open('{{url('/residencia/dictamen_anteproyecto')}}')">Dictamen
                Anteproyecto</a></li>
        <li style=""><a href="{{url('/residencia/documentos_alta_residencia')}}">Enviar documentos de alta de residencia</a></li>

    @endif
@endif