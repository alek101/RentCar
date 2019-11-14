<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RentCar</title>
    
    <link rel="stylesheet" href="{{ url('/css/mainStyle.css') }}">
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
                <a href="/">Korisnicki deo</a>
                <div class="meni">Meni
                    <div class="meniCart">
                        <ul>
                            <li><a href="/kriticni">Kriticni</a></li>
                            <li><a href="/servis">Servis</a></li>
                            <li><a href="/prijem">Dodaj km</a></li>
                            <li><a href="/auto">Spisak automobila</a></li>
                            {{-- <li><a href="/auto/sviModeli">Spisak Modela</a></li> --}}
                            <li><a href="/klient/sviModeli">Spisak Modela</a></li>
                            {{-- <li><a href="/rezervacija">Rezervisi</a></li> --}}
                            <li><a href="/zakazi" target="_blank">Rezervisi</a></li>
                            <li><a href="/rezervacijeInfo/all">Sve Rezervacije</a></li>
                            <li><a href="/rezervacijeInfo">Buduce Rezervacije</a></li>
                        </ul>
                    </div>
                 </div>   
                <div class="adminMeni">Admin
                    <div class="adminMeniCart">
                        <ul>
                            <li><a href="/admin">Admin</a></li>
                            <li><a href="/baza/model/getAdd">Dodaj model</a></li>
                            <li><a href="/baza/model/getChange">Izmeni model i cenu</a></li>
                            <li><a href="/baza/car/getAdd">Dodaj automobil</a></li>
                            <li><a href="/baza/car/getChange">Izmeni vozilo</a></li>
                            <li><a href="/baza/addImage1">Uploaduj Sliku</a></li>
                        </ul>
                    </div>
                </div>
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
    
    <script>
        
        //filter
    
        try {
            if(document.querySelector('#filter')!=null)
            {
                let storedWord=sessionStorage.getItem('filterTabela');
                if(storedWord!=null)
                {
                    document.querySelector('#filter').value=storedWord;
                    search();
                }
                document.querySelector('#filter').addEventListener('change',function(e)
                {
                    search();
                })
            }
            
        } catch (error) {
            console.log("Smisli nesto za: "+error);
        }

        function search()
        {
            let word=document.querySelector('#filter').value.toLowerCase();
                    sessionStorage.setItem('filterTabela',word);
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
        }

        //za hamburger
        // window.addEventListener('scroll', function(){
        //     console.log('radi scroll');
        //     let st = parseInt(document.querySelector('.header').offsetTop);
        //     let pt = parseInt(document.documentElement.scrollTop || document.body.scrollTop);
        //     if(pt>=st)
        //     {
        //         console.log('scroll opcija 1');
        //     }
        //     else
        //     {
        //         console.log('scroll opcija 2');
        //     }
        // })
        
    </script>
</body>
</html>