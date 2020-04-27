@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Información de la empresa
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update') }}" method="post" novalidate>
                            @csrf @method('PATCH')
                            <div class="form-group">
                                <label for="name">Nombre o razón social:</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="form-group">
                                <label for="rfc">R.F.C.:</label>
                                <input type="text" class="form-control {{ $errors->first('rfc') ? 'is-invalid' : '' }}" name="rfc" id="rfc" value="{{ old('rfc', $user->rfc) }}">
                                {!! $errors->first('rfc', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" name="email" id="email"
                                       value="{{ old('email', $user->email) }}">
                                {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <button class="btn btn-primary btn-block">Actualizar datos</button>
                            <button class="btn btn-link btn-block" onclick="event.preventDefault();history.back();">
                                Atrás
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
