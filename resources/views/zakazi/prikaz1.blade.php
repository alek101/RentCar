@extends('index')
@section('PageF')

<section class="rezervacija">
    <div class="velikiTekst">
        <h1>Rezervišite vaš auto</h1>
        <h3>Najbolja ponuda u gradu. Bez učešća, ista za sve vozače, osiguranje uključeno u cenu. Rezervišite odmah!</h3>
    </div>


    <div class="flexRow linkA">
        <a href="#" id="aForma">1</a>
        <a href="#" id="aKartica">2</a>
        <a href="#" id="filterKartica">filter</a>
    </div>

    <div class="meniFilter white flexRow cardDisapear">
        <label for="minCena">Minimalna Cena <input type="number" name="minCena" id="minCena"></label>
        <label for="maxCena">Maksimalna Cena <input type="number" name="maxCena" id="maxCena"></label>
    </div>

    <div class="divForma">
        <div class="formZakazivanje form">
                <div class="flexColumn">
                    <div> @csrf </div>
                    <div class="flexRow">
                        <label for="start" class="w100" id='labelStart'>Datum početka<input type="date" name="dateStart" id="start" value=""> </label>
                        <label for="start2" class="w100 disapear" id='labelStart2'>Datum početka<input type="text" name="start2" id="start2"></label>
                    </div>    
                    <div class="flexRow">
                        <label for="end" class="w100" id='labelEnd'>Datum završetka<input type="date" name="dateEnd" id="end" value="" ></label>
                        <label for="end2" class="w100 disapear" id='labelEnd2'>Datum završetka<input type="text" name="dateEnd2" id="end2"></label>
                    </div>
                    <div class="flexRow">
                    
                        <label for="ime" class="w33"> Ime <input type="text" name="ime" id="ime" value="
                            @auth
                                {{ trim(Auth::user()->name) }}
                            @else
                                {{ "" }}
                            @endauth 
                            "></label>
                        <label for="email" class="w33">Email <input type="email" name="email" id="email" value="
                            @auth
                                {{ Auth::user()->email }}
                            @else
                                {{ "" }}
                            @endauth 
                            "></label>
                        <label for="telefon" class="w33">Telefon <input type="text" name="telefon" id="telefon" value="
                            @auth
                                {{ Auth::user()->phone }}
                            @else
                                 {{ "" }}
                            @endauth 
                            "></label>
                    </div>
                    <div>
                        <label for="comment"> Komentar <br><textarea name="comment" id="comment" cols="30" rows="10" placeholder="no comment"></textarea></label>
                    </div>
                    <div><button class='posalji'>Pošalji uput</button></div>  
                </div>
            </div>
        <div class="response hidden"></div>
        {{-- <div><a href="https://www.animatedimages.org/cat-cars-67.htm"><img src="https://www.animatedimages.org/data/media/67/animated-car-image-0124.gif" border="0" alt="animated-car-image-0124" /></a></div> --}}
    </div>
        

    <div class="divKartice disapear">
        <div class="response2 hidden"></div>
        <div class="modelsWraper"></div>
    </div>
</section>

{{-- Ova sekcija je predvidjena za nesto, na primer komentare ili ponude --}}
{{-- <section class="dodaci">

</section> --}}

<script src="{{ asset('/js/biblioteka.js') }}"></script>
<script src="{{ asset('/js/bookingPage.js') }}"></script>
<script src="{{ asset('/js/booking.js') }}"></script>
<script src="{{ asset('/js/datumi.js') }}"></script>

@endsection