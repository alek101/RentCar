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
                    <a href="/glavna">Idi na admin stranicu</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
