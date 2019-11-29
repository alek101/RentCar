<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RentCar</title>
    
    <link rel="stylesheet" href="{{ url('/css/mainStyle.css') }}">
    <script src={{ asset('/js/mainJS.js') }} defer></script>
    
    <style>
        .container::before 
        {
            background-image: {{ url('image/white=pattern-wallpaper.png') }} ;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="links">
                <a href="/">Korisnički deo</a>
                <div class="meni">Meni
                    <div class="meniCart">
                        <ul>
                            <li><a href="/kriticni">Kritični</a></li>
                            <li><a href="/servis">Servis</a></li>
                            <li><a href="/prijem">Dodaj km</a></li>
                            <li><a href="/auto">Spisak automobila</a></li>
                            <li><a href="/klient/sviModeli">Spisak aktivnih modela</a></li>
                            {{-- <li><a href="/rezervacija">Rezervisi</a></li> --}}
                            <li><a href="/zakazi" target="_blank">Rezerviši</a></li>
                            <li><a href="/rezervacijeInfo/now">Rezervacije u toku</a></li>
                            <li><a href="/rezervacijeInfo/all">Sve rezervacije</a></li>
                            {{-- <li><a href="/rezervacijeInfo">Buduce Rezervacije</a></li> --}}
                        </ul>
                    </div>
                 </div>  
                 @auth
                   @if (Auth::user()->role>=10)
                    <div class="adminMeni">Admin
                        <div class="adminMeniCart">
                            <ul>
                                <li><a href="/admin">Spisak korisnika</a></li>
                                <li><a href="/admin/unactiveAuto">Spisak neaktivnih automobila</a></li>
                                <li><a href="/admin/sviModeli">Spisak svih modela</a></li>
                                <li><a href="/baza/model/getAdd">Dodaj model</a></li>
                                <li><a href="/baza/model/getChange">Izmeni model i cenu</a></li>
                                <li><a href="/baza/car/getAdd">Dodaj automobil</a></li>
                                <li><a href="/baza/car/getChange">Izmeni automobil</a></li>
                                {{-- <li><a href="/baza/addImage1">Uploaduj Sliku</a></li> --}}
                            </ul>
                        </div>
                    </div>
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

        <div class="glavna glavnaAdmin">
                {{-- <div class="margin_20"><label for="filter">Filter tabela: <input type="text" id="filter" class='filter'></label></div> --}}
            @section('Page')
                <h1>Dobrodosli u admin panel</h1>

                
                
                
            @show
        </div>

        <div class="footer">
            <div>
                Završni rad: RentCar
            </div>

            <div>
                Aleksandar Petrović <br>
                PHP grupa II
            </div>
        </div>
    </div>
    
    
    
</body>
</html>