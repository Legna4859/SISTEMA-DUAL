@if(Session::has("msg_ok"))
    <script type="text/javascript">
        Swal.fire(
            'Excelente!',
            'Se ha cargado correctamente tu evidencia!',
            'success'
        )
    </script>
@endif
@php
    Session::forget('msg_ok');
@endphp