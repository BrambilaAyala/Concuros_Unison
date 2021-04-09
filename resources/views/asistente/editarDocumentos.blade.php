@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="container container-h-secundario">
                    <div class="card-header h-secundario">{{ __('Resubida de documentos rechazados.') }}</div>
                </div>
                
                <div class="card-body">
                    <form method="POST" id="" action="{{route('asistentes.update', Auth::user()->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")

                        <div class="form-group row">
                            <label for="foto_asistente" class="col-md-4 col-form-label text-md-right">{{ __('Foto del Asistente') }}</label>

                            <div class="col-md-6">
                                <input id="foto_asistente" type="file" class="form-control" name="foto_asistente" required autocomplete="foto_asistente">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="acta_asistente" class="col-md-4 col-form-label text-md-right">{{ __('Acta de nacimiento') }}</label>

                            <div class="col-md-6">
                                <input id="acta_asistente" type="file" class="form-control" name="acta_asistente" required autocomplete="acta_asistente">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="constancia_escuela" class="col-md-4 col-form-label text-md-right">{{ __('Constancia escolar') }}</label>

                            <div class="col-md-6">
                                <input id="constancia_escuela" type="file" class="form-control" name="constancia_escuela" required autocomplete="constancia_escuela">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Resubir archivo/s') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection