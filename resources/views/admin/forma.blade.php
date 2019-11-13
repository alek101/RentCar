@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($users);
@endphp --}}

<form method="POST" action="/admin/change">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" id='token'> --}}
    <input type="number" name='id' id='id' value={{ $users->id }} hidden>
    Name <input type="text" name="name" id="name" value="{{ $users->name }}" readonly>
    Email <input type="email" name="meil" id="meil" value="{{ $users->email }}" readonly>
    Role    <input type="number" name="role" id="role" value="{{ $users->role }}">
    <input type="submit" value="Promeni" id="dugme">

</form>
@endsection