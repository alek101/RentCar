@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Vi ste ulogovani!
                    <br>
                    <a href="/">Povratak na glavnu stranicu</a>
                    <br>
                    @if (Auth::user()->role>=10)
                        <a href="/glavna">Idi na admin stranicu</a>
                        <br>
                    @endif
                    
                    <a href="/izmeniPodatkeUser">Promeni podatke</a>

                    <br>

                    <a href="/izmeniLozinku">Promeni lozinku</a>

                    <br>

                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
