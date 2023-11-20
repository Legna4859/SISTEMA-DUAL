@foreach($auditores as $auditor)
    @foreach($personas as $persona)
        @if($auditor->id_auditor==$persona->id_personal)
            <option value="{{$auditor->id_asigna_audi}}">{{$persona->nombre}}</option>
        @endif
    @endforeach
@endforeach
