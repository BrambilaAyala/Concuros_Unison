@extends('layouts.app_admin')

@section('content')

@php
    //dd($asistente);
@endphp

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1 class="m-0 text-dark">Validacion del asistente {{$asistente->nombre}}</h1>
                <hr style="background-color: black;">
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid ">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>
    
            <form role="form" method="POST" action="{{route('validaciones.update', $asistente->id)}}">
                @csrf
                @method("PUT")
                <div class="card-body">
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Nombre: </label>
                        <label for="">{{$asistente->nombre.' '.$asistente->apellido_paterno.' '.$asistente->apellido_materno}}</label>
                    </div>

                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Fecha de nacimiento:</label>
                        <label for="">{{$asistente->fecha_nacimiento}}</label>
                    </div>

                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">CURP: </label>
                        <label for="">{{$asistente->curp}}</label>
                    </div>

                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Escuela de origen:</label>
                        <label for="">{{$asistente->escuela_origen}}</label>
                    </div>

                    <hr>

                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Foto identificatoria:</label>
                        <img src="/storage/{{$asistente->foto_asistente}}" style="height: 180px" alt="">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="fotoRechazo" value="Foto identificatoria" onchange="javascript:showContent('customCheckbox1', 'textFoto')">
                            <label for="customCheckbox1" class="custom-control-label">Rechazar Foto identificatoria?</label>
                        </div>
                        <div class="form-group" style="font-size: 20px; display: none;" id="textFoto">
                            <textarea style="width: 100%" name="textoFotoRechazo" id="" cols="" rows="3" placeholder="Introduzca un breve texto sobre la razón de rechazo"></textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Acta de nacimiento:</label>
                        <img src="/storage/{{$asistente->acta_asistente}}" style="height: 600px" alt="">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox2" name="actaRechazo" value="Acta de nacimiento" onchange="javascript:showContent('customCheckbox2', 'textActa')">
                            <label for="customCheckbox2" class="custom-control-label">Rechazar Acta de nacimiento?</label>
                        </div>
                        <div class="form-group" style="font-size: 20px; display: none;" id="textActa">
                            <textarea style="width: 100%" name="textoActaRechazo" id="" cols="" rows="3" placeholder="Introduzca un breve texto sobre la razón de rechazo"></textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Constancia escolar:</label>
                        <img src="/storage/{{$asistente->constancia_escuela}}" style="height: 600px" alt="">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox3" name="constanciaRechazo" value="Constancia escolar" onchange="javascript:showContent('customCheckbox3', 'textConstancia')">
                            <label for="customCheckbox3" class="custom-control-label">Rechazar Constancia escolar?</label>
                        </div>
                        <div class="form-group" style="font-size: 20px; display: none;" id="textConstancia">
                            <textarea style="width: 100%" name="textoConstanciaRechazo"  cols="" rows="3"  placeholder="Introduzca un breve texto sobre la razón de rechazo"></textarea>
                        </div>
                    </div>
    
                </div>
    
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" aria-required="true">Validar</button>
                    <a type="button" href="{{route('revisores.lista-espera')}}" class="btn btn-secondary" aria-required="true">Cancelar</a>
                </div>
            </form>      
        </div>
    </div>
</div>

<script type="text/javascript">
    function showContent(e, e2) {
        element = document.getElementById(e2);
        check = document.getElementById(e);
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
</script>

@endsection