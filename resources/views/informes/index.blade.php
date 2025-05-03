@extends('layouts.dashboard')

@section('title', 'Informes')

@section('content')
<div class="row">
    @if(Auth::user()->tieneRol('Administrador') || Auth::user()->tieneRol('Instructor'))
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informe de Usuarios</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('informes.usuarios') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                        <select name="tipo_usuario" id="tipo_usuario" class="form-select">
                            <option value="todos">Todos</option>
                            <option value="estudiantes">Estudiantes</option>
                            <option value="instructores">Instructores</option>
                            <option value="administradores">Administradores</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select">
                            <option value="todos">Todos</option>
                            <option value="activos">Activos</option>
                            <option value="inactivos">Inactivos</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formato" class="form-label">Formato</label>
                        <select name="formato" id="formato" class="form-select">
                            <option value="web">Web</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar Informe</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informe de Cursos</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('informes.cursos') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="estado_curso" class="form-label">Estado del Curso</label>
                        <select name="estado_curso" id="estado_curso" class="form-select">
                            <option value="todos">Todos</option>
                            <option value="activos">Activos</option>
                            <option value="finalizados">Finalizados</option>
                            <option value="proximos">Próximos</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formato" class="form-label">Formato</label>
                        <select name="formato" id="formato" class="form-select">
                            <option value="web">Web</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar Informe</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informe de Inscripciones</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('informes.inscripciones') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="id_curso" class="form-label">Curso</label>
                        <select name="id_curso" id="id_curso" class="form-select">
                            <option value="">Todos</option>
                            @foreach(App\Models\Curso::all() as $curso)
                            <option value="{{ $curso->Id_Curso }}">{{ $curso->Curso }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_desde" class="form-label">Fecha Desde</label>
                        <input type="date" name="fecha_desde" id="fecha_desde" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                        <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="formato" class="form-label">Formato</label>
                        <select name="formato" id="formato" class="form-select">
                            <option value="web">Web</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar Informe</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informe de Evaluaciones</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('informes.evaluaciones') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="id_curso" class="form-label">Curso</label>
                        <select name="id_curso" id="id_curso" class="form-select">
                            <option value="">Todos</option>
                            @foreach(App\Models\Curso::all() as $curso)
                            <option value="{{ $curso->Id_Curso }}">{{ $curso->Curso }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_desde" class="form-label">Fecha Desde</label>
                        <input type="date" name="fecha_desde" id="fecha_desde" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                        <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="formato" class="form-label">Formato</label>
                        <select name="formato" id="formato" class="form-select">
                            <option value="web">Web</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar Informe</button>
                </form>
            </div>
        </div>
    </div>
    
    @if(Auth::user()->tieneRol('Administrador'))
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informe de Programas</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('informes.programas') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="id_escuela" class="form-label">Escuela</label>
                        <select name="id_escuela" id="id_escuela" class="form-select">
                            <option value="">Todas</option>
                            @foreach(App\Models\Escuela::all() as $escuela)
                            <option value="{{ $escuela->Id_Escuela }}">{{ $escuela->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formato" class="form-label">Formato</label>
                        <select name="formato" id="formato" class="form-select">
                            <option value="web">Web</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar Informe</button>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endif
    
    @if(Auth::user()->tieneRol('Estudiante'))
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Mi Informe Académico</h5>
            </div>
            <div class="card-body">
                <p>Genere un informe con su historial académico, incluyendo cursos, evaluaciones y notas finales.</p>
                <a href="{{ route('informes.estudiante') }}" class="btn btn-primary">Generar Informe PDF</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection