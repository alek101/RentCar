<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RentCar</title>
    <link rel="stylesheet" href="{{ url('/css/mainStyle.css') }}">
    <script src={{ asset('/js/mainJS.js') }} defer></script>
    {{-- -develpment version --}}
    <script src="{{ asset('/js/vue.js') }}" defer></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js" defer></script> --}}

    {{-- prodaction version --}}
    {{-- <script src="{{ asset('/js/vue.min.js') }}" defer></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0" defer></script> --}}

    <script src="{{ asset('/js/biblioteka.js') }}" defer></script>
    <script src="{{ asset('/js/vueBooking.js') }}" defer></script>
    <script src="{{ asset('/js/validateForm.js') }}" defer></script>
    <script src="{{ asset('/js/vueAds.js') }}" defer></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="links">
                <a href="/klient/nama">O Nama</a>
                <a href="/zakazi">Rezerviši</a>
                <a href="/klient/sviModeli">Svi Modeli</a>
                <a href="/klient/uslovi">Uslovi korišćenja</a>
                {{-- <a href="/zakazi/zakaziStaro">ZakažiJS</a> --}}
                @auth
                   @if (Auth::user()->role>=1)
                       <a href="/kriticni">Zaposleni</a>
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
                <span><a href="http://www.facebook.com"><img class="img_drust_m" src="/images/facebook_logos_PNG19748.png" alt="facebook"></a></span>
                <span><a href="http://www.instragram.com"><img class="img_drust_m" src="/images/instagram_PNG11.png" alt="instagram"></a></span>
                <span><a href="http://www.twitter.com"><img class="img_drust_m" src="/images/twitter_PNG14.png" alt="twitter"></a></span>
            </div>
        </div>
        
    </div>

    
    
</body>
</html>