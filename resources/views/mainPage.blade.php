<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RentCar</title>
</head>
<body>
    <div class="header">
        <div class="links">
            <a href="/kriticni">Kriticni</a>
            <a href="/servis">Servis</a>
            <a href="/prijem">Dodaj km</a>
            <a href="/auto">Spisak automobila</a>
            <a href="/rezervacija">Rezervisi</a>
            <a href="/rezervacijeInfo/sve">Sve Rezervacije</a>
            <a href="/rezervacijeInfo">Buduce Rezervacije</a>
        </div>

        <div class="login">
                @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        
    </div>

    @section('Page')
        <h1>Dobrodosli</h1>
    @show

    <div class="footer">
        Ovo je footer!
    </div>

    
</body>
</html>