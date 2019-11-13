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
                <a href="/nama">O Nama</a>
                <a href="/zakazi">Zakazi</a>
                <a href="/klient/sviModeli">Svi Modeli</a>
                <a href="/kriticni">Admin Panel</a>
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
                Telefon: 011/xxx-xx-xx
            </div>

            <div>
                Aleksandar Petrović <br>
                PHP grupa II
            </div>
        </div>
        
    </div>

    <script>
        
            //filter
        
            try {
            if(document.querySelector('#filter')!=null)
            {
                document.querySelector('#filter').addEventListener('change',function(e)
                {
                    let word=document.querySelector('#filter').value.toLowerCase();
                    let trNiz=[...document.querySelectorAll('tr')];
                    for(tr of trNiz)
                    {
                        let array=[...tr.childNodes];
                        let c1=false; let c2=false;
                        array.map(function(c)
                        {
                            if(c.tagName=='TD')
                            {
                                c1=true;
                            }

                            if(typeof(c.innerHTML)==='string' && c.innerHTML.toLowerCase().includes(word))
                            {
                                c2=true;
                            }
                        })
                        
                        if(c1 && c2)
                        {
                            tr.classList.remove('disapear');
                        }
                        else if(c1 && !c2)
                        {
                            tr.classList.add('disapear');
                        }
                    }
                })
            }
            
        } catch (error) {
            console.log("Smisli nesto za: "+error);
        }
            
        </script>
    
</body>
</html>