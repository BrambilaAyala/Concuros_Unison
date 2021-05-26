@extends('layouts.app_admin')

@section('content')

@php
    //dd($validacion);
@endphp

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1 class="m-0 text-dark">Validacion del asistente {{$validacion->nombre}}</h1>
                <hr style="background-color: black;">
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid ">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Informacion del Asistente</h3>
            </div>
    
            <form role="form" method="POST" action="{{route('validaciones.update', $validacion->id)}}">
                @csrf
                @method("PUT")
                <div class="card-body">
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Nombre: </label>
                        <label for="">{{$validacion->nombre.' '.$validacion->apellido_paterno.' '.$validacion->apellido_materno}}</label>
                    </div>

                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Fecha de nacimiento:</label>
                        <label for="">{{$validacion->fecha_nacimiento}}</label>
                    </div>

                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">CURP: </label>
                        <label for="">{{$validacion->curp}}</label>
                    </div>

                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Escuela de origen:</label>
                        <label for="">{{$validacion->escuela_origen}}</label>
                    </div>

                    <hr>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Imagenes del Asistente</h3>
                        </div>
                        <div class="form-group" style="font-size: 20px">
                            <label class="col-md-2 col-form-label text-md-left" for="">Foto identificatoria:</label>
                            <img src="/storage/{{$validacion->foto_asistente}}" style="height: 180px" alt="">
    
                            <p><b>
                                <input type="radio" name="fotoRechazo" value="{{null}}" onchange="sholo('#textFoto','esconder')" checked/>&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="fotoRechazo" value="Foto identificatoria" onchange="sholo('#textFoto','mostrar')"/>&nbsp;Rechazar
                            </b></p>
    
                            <div class="form-group" style="font-size: 20px; display:none;" id="textFoto">
                                <textarea style="width: 100%" name="textoFotoRechazo" id="" cols="" rows="3" placeholder="Introduzca un breve texto sobre la razón de rechazo"></textarea>
                            </div>
                        </div>
    
                        <hr>
    
                        <div class="form-group" style="font-size: 20px">
                            <label class="col-md-2 col-form-label text-md-left" for="">Acta de nacimiento:</label>
                            <img src="/storage/{{$validacion->acta_asistente}}" style="height: 600px" alt="">
    
                            <p><b>
                                <input type="radio" name="actaRechazo" value="{{null}}" onchange="sholo('#textActa','esconder')" checked/>&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="actaRechazo" value="Acta de nacimiento" onchange="sholo('#textActa','mostrar')"/>&nbsp;Rechazar
                            </b></p>
    
                            <div class="form-group" style="font-size: 20px; display: none;" id="textActa">
                                <textarea style="width: 100%" name="textoActaRechazo" id="" cols="" rows="3" placeholder="Introduzca un breve texto sobre la razón de rechazo"></textarea>
                            </div>
                        </div>
    
                        <hr>
    
                        <div class="form-group" style="font-size: 20px">
                            <label class="col-md-2 col-form-label text-md-left" for="">Constancia escolar:</label>
                            <img src="/storage/{{$validacion->constancia_escuela}}" style="height: 600px" alt="">
    
                            <p><b>
                                <input type="radio" name="constanciaRechazo" value="{{null}}" onchange="sholo('#textConstancia','esconder')" checked/>&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="constanciaRechazo" value="Constancia escolar" onchange="sholo('#textConstancia','mostrar')"/>&nbsp;Rechazar
                            </b></p>
    
                            <div class="form-group" style="font-size: 20px; display: none;" id="textConstancia">
                                <textarea style="width: 100%" name="textoConstanciaRechazo"  cols="" rows="3"  placeholder="Introduzca un breve texto sobre la razón de rechazo"></textarea>
                            </div>
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
    function sholo(e, e2) {
        if(e2 =="esconder"){
            $(e).hide();
        } else if (e2 == "mostrar") {
            $(e).show();
        } 
    };
</script>

@endsection