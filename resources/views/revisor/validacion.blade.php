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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Abrir
                        </button>
                    </div>
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Acta de nacimiento:</label>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Abrir
                        </button>
                    </div>
                    <div class="form-group" style="font-size: 20px">
                        <label class="col-md-2 col-form-label text-md-left" for="">Constancia escolar:</label>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Abrir
                        </button>
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
                    <a type="button" href="{{route('revisores.lista-espera')}}" class="btn btn-secondary" aria-required="true">Cancelar</a>
                </div>
            </form>      
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         {{--  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <embed src="/storage/Brochure.pdf" type="application/pdf" width="100%" height="600px" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection