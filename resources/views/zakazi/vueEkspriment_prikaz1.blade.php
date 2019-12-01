DEPRICATED
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
                    <div class="flexRow" id="vueSelector">
                        <div class="flexRow" id="dateStartGroup">
                            <label for="start" class="" id='labelStart' v-if="dateStartModel==null">Datum početka<input type="date" name="dateStart" id="start" v-model="dateStartModel" v-on:change="inputStartDate()"> </label>
                            <label for="start2" class="" id='labelStart2' v-else>Datum početka<input type="text" name="start2" id="start2" :value="dateStartNew" v-on:click="outputStartDate()"></label>
                        </div>    
                        <div class="flexRow" id="dateEndGroup">
                            <label for="end" class="" id='labelEnd' v-if="dateEndModel==null">Datum završetka<input type="date" name="dateEnd" id="end" v-model="dateEndModel"  v-on:change="inputEndDate()"></label>
                            <label for="end2" class="" id='labelEnd2' v-else>Datum završetka<input type="text" name="dateEnd2" id="end2" :value="dateEndNew" v-on:click="outputEndDate()"></label>
                        </div>
                    </div>
                    
                    <div class="flexRow">
                    
                        <label for="ime" class="w33"> Ime <input type="text" name="ime" id="ime" value="
                            @auth
                                {{ Auth::user()->name }}
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

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="{{ asset('/js/biblioteka.js') }}"></script>
<script src="{{ asset('/js/vueDatumi.js') }}"></script>
<script src="{{ asset('/js/bookingPage.js') }}"></script>
<script src="{{ asset('/js/booking.js') }}"></script>
{{-- <script src="{{ asset('/js/datumi.js') }}"></script> --}}
<script src="{{ asset('/js/bookingTrim.js') }}"></script>

@endsection