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
                <a href="/kriticni">Kriticni</a>
                <a href="/servis">Servis</a>
                <a href="/prijem">Dodaj km</a>
                <a href="/auto">Spisak automobila</a>
                <a href="/rezervacija">Rezervisi</a>
                <a href="/rezervacijeInfo/sve">Sve Rezervacije</a>
                <a href="/rezervacijeInfo">Buduce Rezervacije</a>
                <a href="/admin">Admin</a>
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
                Aleksandar Petrović
                PHP grupa II
            </div>
        </div>
    </div>
    
    <script>
        
        //filter
    
        try {
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
        } catch (error) {
            console.log("Smisli nesto za: "+error);
        }
        
    </script>
</body>
</html>