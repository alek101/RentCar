<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RentCar</title>
    <style>

        html
        {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body
        {
            width: 100%;
            height: 100%;
            margin:0;
            padding:0;
            box-sizing: border-box;
            
        }

        *
        {
            margin:0;
            padding:0;
            box-sizing: border-box;
        }

        .container
        {
            /* background-image: linear-gradient(lightblue,rgb(85, 85, 114)); */
            position: relative;
            height: 100%;
            max-width: 1400px;
            margin: 0 auto;
            
        }

        .container::before {
            content: "";
            background-image: linear-gradient(lightblue,blue);
            opacity: 0.6;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: -1000;
        }
        

        a 
        {
            text-decoration: none;
        }

        ol,ul,li
        {
            list-style-type: none;
        }
        
        .header
        {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            background-color: crimson;
            height: 80px;
            font-size: 1.2em;
        }

        a:link 
        {
        color: white;
        }

        /* visited link */
        a:visited 
        {
        color: white;
        }

        /* mouse over link */
        a:hover 
        {
        color: blue;
        font-weight: bold;
        }

        /* selected link */
        a:active 
        {
        color: blue;
        font-weight: bold;
        }

        .links
        {
            padding: 25px;
        }

        .links a
        {
            padding-right: 10px;
        }

        .footer
        {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            background-color: crimson;
            height: 80px;
            font-size: 1.2em;
            position: absolute;
            bottom: 0px;
            width: 100%;
            color: white;
            padding: 10px;
        }

        .glavna
        {
            width: 100%;
            height: 80vh;
            text-align: center;
            overflow-y: scroll;
        }
    
        table
        {
            border: 3px solid crimson;
            margin: 20px auto;
            border-collapse: collapse;
            max-width: 1280px;
        }

        tr
        {
            background-color: chartreuse;
        }

        tr:nth-child(2n)
        {
            background-color: green;
        }

        th
        {
            background-color: gray;
            /* border: 1px solid black; */
            padding: 3px 5px;
        }

        td
        {
            /* border: 1px solid black; */
            padding: 3px 5px;
        }

        table a:link
        {
            color: black;
        }

        table a:visited
        {
            color: black;
        }

        table a:hover
        {
            color: red;
            font-weight: bold;
        }

        table a:active
        {
            color: red;
            font-weight: bold;
        }

        h1,h3
        {
            margin: 10px auto;
        }

        form, .forma
        {
            background-color: lightgreen;
            margin: 20px auto;
            padding: 20px;
        }

        form,.forma *
        {
            padding: 2px;
            margin: 3px;
        }
        
        button,#dugme
        {
            padding: 5px;
            box-shadow: 2px 2px gray;
        }

        button,#dugme:hover
        {
            cursor: pointer;
            box-shadow: 0px 0px gray;
        }

        .hidden
        {
            visibility: hidden;
        }

        .kartica
        {
            position: absolute;
            top: 30%; left: 35%;
            height: 50px; width: 200px;
            border: 2px solid crimson;
            background-color: chartreuse;
            z-index: 10;
            padding: 5px;
            box-shadow: 2px 5px 10px rbga(0,0,0,0.5);
            transition: 0.3s;
        }

        .kartica:hover
        {
            box-shadow: 2px 10px 20px rbga(0,0,0,0.5);
        }

        .info_rez
        {
            font-size: 1.4em;
            color: crimson;
            margin: 30px auto;
        }

        .bckRed
        {
            background-color: red;
            border: 1px solid green;
            font-weight: bold;
        }

        .response
        {
            border: 1px solid crimson;
            background-color: aqua;
        }

        .flexRow
        {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin: 5px;
        }

        .flexColumn
        {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sveRez
        {
            max-width: 490px;
            margin: 10px auto;
        }

        .glavna::-webkit-scrollbar
        {
            /* mora nesto da bude upisano u -scrollbar ; mora da bude povezano
            sa elementom koji ima scrolbar */
            /* background-color: green; */
            width: 15px;
        }

        .glavna::-webkit-scrollbar-thumb
        {
            border-radius: 6px;
            background-color: green;
        }

        .glavna::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px;
            background-color: #f5f5f5;
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
    
</body>
</html>