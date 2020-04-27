@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Bienvenid@ de nuevo, {{ Auth::user()->name }}

                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#test-spinner').on('click', function () {
                const btn = $(this).children('button');
                btn.prop('disabled', true);
                btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            });
        });
    </script>
@stop
