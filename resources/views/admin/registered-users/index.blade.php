@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Usuarios registrados</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-striped" id="DataTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>RFC</th>
                                <th>Rol</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->id }}</td>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->rfc }}</td>
                                    <td>{!! makeRoleBadge($usuario->is_admin) !!}</td>
                                    <td>
                                        <button type="button" data-id="{{ $usuario->id }}" class="btn btn-link update">Actualizar</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No existen registros.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.users.change-admin') }}" method="post" id="ChangeAdmin" class="d-none">
        @csrf
        <input type="hidden" name="id" value="">
    </form>
@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            const table = $('#DataTable').DataTable({
                'language': {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                'info': false,
                'order': [
                    [0, 'asc']
                ],
            });

            $('.update').on('click', function () {
                const id = $(this).data('id');
                const form = $('#ChangeAdmin');

                $.alert({
                    title: 'Confirmar',
                    content: '¿Desear cambiar el rol de este usuario?',
                    buttons: {
                        confirmar: function () {
                            form.find('input[name=id]').val(id);
                            form.submit();
                        },
                        cancelar: function () {
                            $.alert('Acción cancelada');
                        }
                    }
                });
            });
        });
    </script>
@stop
