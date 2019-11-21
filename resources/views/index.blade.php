<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RentCar</title>
    <link rel="stylesheet" href="{{ url('/css/mainStyle.css') }}">
    <script src={{ asset('/js/mainJS.js') }} defer></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="links">
                <a href="/klient/nama">O Nama</a>
                <a href="/zakazi">Zakaži</a>
                <a href="/klient/sviModeli">Svi Modeli</a>
                <a href="/klient/uslovi">Uslovi korišćenja</a>
                @auth
                   @if (Auth::user()->role>=1)
                       <a href="/kriticni">Admin Panel</a>
                   @endif 
                @endauth
                
            </div>

            <div class="login">
                    @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <a href="{{ url('/home') }}">{{ Auth::user()->name }}</a>
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
                
                <a href="https://www.animatedimages.org/cat-cars-67.htm"><img src="https://www.animatedimages.org/data/media/67/animated-car-image-0035.gif" border="0" alt="animated-car-image-0035" /></a>

                {{-- <img src="{!! asset('images/citroen-c3-1-4-hdi.jpg') !!}" alt="nema">
                <img src="{!! asset('images/peugeot-208-1-4-hdi.jpg') !!}" alt="nema">
                <img src="{!! asset('images/peugeot-308-1-6-hdi.jpg') !!}" alt="nema">
                <img src="{!! asset('images/seat-ibiza-1-2-tdi.jpg') !!}" alt="nema"> --}}
               
                
            @show
        </div>

        <div class="footer">
            <div>
                Najbolja RentCar Agencija <br>
                Adresa: Nepoznata BB <br>
                
            </div>

            <div>
                Telefon: 011/xxx-xx-xx <br>
                Radno vreme: 6h-22h
            </div>

            <div>
                Aleksandar Petrović <br>
                PHP grupa II
            </div>
        </div>
        
    </div>

    
    
</body>
</html>