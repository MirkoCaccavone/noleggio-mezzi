@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Titolo della dashboard --}}
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                {{-- Header della card --}}
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">
                    {{-- Mostra un messaggio di successo se presente nella sessione --}}
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{-- Messaggio di conferma login --}}
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
