@extends('layouts.dashboard')

@section('title', 'Detalles de la Escuela')

@section('actions')
<a href="{{ route('escuelas.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@if(Auth::user()->tieneRol('Administrador'))
<a href="{{ route('escuelas.edit', $escuela->id_escuela) }}" class="btn btn-warning">
    <i class="fas fa-edit"></i> Editar
</a>
@endif
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-4">{{ $escuela->nombre }}</h3>
                <p class="lead">{{ $escuela->descripcion }}</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h4>Programas de Formación Asociados</h4>
                @if($escuela->programas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Curso</th>
                                <th>Ubicación</th>
                                <th>Responsable</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($escuela->programas as $programa)
                            <tr>
                                <td>{{ $programa->tipoEscuela->tipos_escuela }}</td>
                                <td>{{ $programa->curso->curso }}</td>
                                <td>{{ $programa->ubicacion->ubicacion }}</td>
                                <td>{{ $programa->responsable->primer_nombre }} {{ $programa->responsable->primer_apellido }}</td>
                                <td>
                                    <a href="{{ route('programas.show', $programa->id_programa) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p>No hay programas de formación asociados a esta escuela.</p>
                @endif
            </div>
        </div>

        @if(Auth::user()->tieneRol('Administrador'))
        <div class="row mt-4">
            <div class="col-12 text-end">
                <a href="{{ route('programas.create') }}?escuela={{ $escuela->id_escuela }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Programa para esta Escuela
                </a>
            </div>
        </div>
        @endif

        <div class="row mt-4">
            <div class="col-12">
                <h4>Estadísticas</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5>Total de Programas</h5>
                                <h3>{{ $escuela->programas->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5>Programas Activos</h5>
                                <h3>{{ $escuela->programas->filter(function($programa) {
                                    return now()->between(
                                        $programa->curso->fecha_inicio instanceof \Carbon\Carbon ? $programa->curso->fecha_inicio : \Carbon\Carbon::parse($programa->curso->fecha_inicio),
                                        $programa->curso->fecha_fin instanceof \Carbon\Carbon ? $programa->curso->fecha_fin : \Carbon\Carbon::parse($programa->curso->fecha_fin)
                                    );
                                })->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5>Total de Estudiantes</h5>
                                <h3>{{ $escuela->programas->sum(function($programa) {
                                    return $programa->curso->cantidad_alumnos;
                                }) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5>Disponibilidad de Cupos</h5>
                                <h3>{{ $escuela->programas->sum(function($programa) {
                                    return $programa->curso->cupos - $programa->curso->cantidad_alumnos;
                                }) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h4>Tipos de Programas</h4>
                @php
                $tiposProgramas = $escuela->programas->groupBy(function($programa) {
                    return $programa->tipoEscuela->tipos_escuela;
                });
                @endphp
                
                @if(count($tiposProgramas) > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tipo de Programa</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tiposProgramas as $tipo => $programas)
                            <tr>
                                <td>{{ $tipo }}</td>
                                <td>{{ count($programas) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p>No hay datos de tipos de programas disponibles.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection