<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RentCar</title>
    <link rel="stylesheet" href="{{ url('/css/mainStyle.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="links">
                <a href="/zakazi">Zakazi</a>
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

        <div class="glavna">
            @section('PageF')
                <h1>Dobrodosli</h1>

                {{-- http://rentacarserbia.com/sr/strana/cenovnik --}}
                
               

                <img src="{!! asset('images/citroen-c3-1-4-hdi.jpg') !!}" alt="nema">
                <img src="{!! asset('images/peugeot-208-1-4-hdi.jpg') !!}" alt="nema">
                <img src="{!! asset('images/peugeot-308-1-6-hdi.jpg') !!}" alt="nema">
                <img src="{!! asset('images/seat-ibiza-1-2-tdi.jpg') !!}" alt="nema">
               
                
            @show
        </div>

        <div class="footer">
            <div>
                Završni rad: RentCar
            </div>

            <div>
                Aleksandar Petrović
                PHP grupa II
            </div>
        </div>
        
    </div>
    
</body>
</html>