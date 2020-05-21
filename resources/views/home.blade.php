@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="jumbotron">
                    <h1 class="display-3">Bienvenid@</h1>
                    <p class="lead">{{ Auth::user()->name }}</p>
                    {{-- <hr class="my-2">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card-counter danger">
                                <i class="fas fa-dollar-sign"></i>
                                <a href="{{ route('account.index') }}">
                                    <span class="count-numbers">{{ $saldo }}</span>
                                    <span class="count-name">Saldo actual</span>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card-counter success">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <a href="{{ route('documents.index', 'I') }}">
                                    <span class="count-numbers">6875</span>
                                    <span class="count-name">Facturas</span>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card-counter info">
                                <i class="fas fa-piggy-bank"></i>
                                <a href="{{ route('documents.index', 'P') }}">
                                    <span class="count-numbers">35</span>
                                    <span class="count-name">REP</span>
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    <a href="{{ route('ajax') }}">Prueba ajax</a>
                </div>
            </div>
        </div>
    </div>
@stop
