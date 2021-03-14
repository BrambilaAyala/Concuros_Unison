@extends('layouts.app_admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1 class="m-0 text-dark">Validacion del asistente [Nombre]</h1>
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
    
            <form role="form">
                <div class="card-body">
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Nombre: </label>
                        <label for=""></label>
                    </div>
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Fecha de nacimiento:</label>
                        <label for=""></label>
                    </div>
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">CURP: </label>
                        <label for=""></label>
                    </div>
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Ciudad de origen:</label>
                        <label for=""></label>
                    </div>
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Escuela de origen:</label>
                        <label for=""></label>
                    </div>
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Foto identificatoria:</label>
                        <a href="#"> direccion para ver documento</a>
                    </div>
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Acta de nacimiento:</label>
                        <a href="#" >direccion para ver documento</a>
                    </div>
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Constancia escolar:</label>
                        <a href="#">direccion para ver documento</a>
                    </div>
    
    
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio">
                            <label for="customRadio1" class="custom-control-label">Aprovado</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio">
                            <label for="customRadio2" class="custom-control-label">Rechazado</label>
                        </div>
                    </div>
    
                    <div class="form-group col-sm-2">
                        <label>Razón de rechazo</label>
                        <select class="custom-select">
                            <option>Seleccionar</option>
                            <option>Foto</option>
                            <option>Acta</option>
                            <option>Constancia</option>
                            <option>Todas las anteriores</option>
                        </select>
                    </div>
    
                    <div class="form-group" style="font-size: 20px">
                        <textarea style="width: 100%" name="" id="" cols="" rows="3" placeholder="Introduzca un breve texto sobre la razón de rechazo"></textarea>
                    </div>
                  
    
                </div>
    
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" aria-required="true">Vlidar</button>
                </div>
            </form>      
        </div>
    </div>
</div>
@endsection