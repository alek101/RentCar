@extends('index')
@section('PageF')

{{-- koristi vue --}}

<div> @csrf </div> 
{{-- csrf izvan Vua --}}

<div class="rezervacija"  id="vueSelector">
    <div class="velikiTekst">
        <h1>Rezervišite vaš auto</h1>
        <h3>Najbolja ponuda u gradu. Bez učešća, ista za sve vozače, osiguranje uključeno u cenu. Rezervišite odmah!</h3>
    </div>


    <div class="flexRow linkA">
        <a href="#" id="aForma"  @click='kartica1'>1</a>
        <a href="#" id="aKartica"  @click='kartica2'>2</a>
        <a href="#" id="filterKartica" @click='filterUklj'>filter</a>
    </div>

    <div class="meniFilter white flexRow" v-if="filter">
        <label for="minCena">Minimalna Cena <input type="number" name="minCena" id="minCena" v-model="minCena" @change='filterCena'></label>
        <label for="maxCena">Maksimalna Cena <input type="number" name="maxCena" id="maxCena" v-model="maxCena" @change='filterCena'></label>
    </div>

    <div class="divForma" v-if='karticaForma'>
        <div class="formZakazivanje form">
                <div class="flexColumn">
                    
                    <div class="flexRow">
                        <div class="flexRow" id="dateStartGroup">
                            <label for="start" class="" id='labelStart' v-if="dateStartModel==null">Datum početka<input type="date" name="dateStart" id="start" v-model="dateStartModel" @change="inputStartDate"> </label>
                            <label for="start2" class="" id='labelStart2' v-else>Datum početka<input type="text" name="start2" id="start2" :value="dateStartNew" @click="outputStartDate"></label>
                        </div>    
                        <div class="flexRow" id="dateEndGroup">
                            <label for="end" class="" id='labelEnd' v-if="dateEndModel==null">Datum završetka<input type="date" name="dateEnd" id="end" v-model="dateEndModel"  @change="inputEndDate"></label>
                            <label for="end2" class="" id='labelEnd2' v-else>Datum završetka<input type="text" name="dateEnd2" id="end2" :value="dateEndNew" @click="outputEndDate"></label>
                        </div>
                    </div>
                    
                    <div class="flexRow">
                    
                        <label for="ime" class="w33" id="imeLabel"> Ime <input type="text" name="ime" id="ime" value="
                            @auth
                                {{ Auth::user()->name }}
                            @else
                                {{ "" }}
                            @endauth 
                            " v-model='imeModel'></label>
                        <label for="email" class="w33" id='emailLabel'>Email <input type="email" name="email" id="email" value="
                            @auth
                                {{ Auth::user()->email }}
                            @else
                                {{ "" }}
                            @endauth 
                            " v-model='emailModel'></label>
                        <label for="telefon" class="w33" id='telefonLabel'>Telefon <input type="text" name="telefon" id="telefon" value="
                            @auth
                                {{ Auth::user()->phone }}
                            @else
                                 {{ "" }}
                            @endauth 
                            " v-model='telefonModel'></label>
                    </div>
                    <div>
                        <label for="comment"> Komentar <br><textarea name="comment" id="comment" cols="30" rows="10" v-model='commentModel'></textarea></label>
                    </div>
                    <div><button class='posalji' @click.prevent='prviUput'>Pošalji uput</button></div>  
                </div>
            </div>
        <div class="response" v-show="errors.length!=0">
            <p v-for="error in errors">@{{ error }}</p>
        </div>
    </div>
        

    <div class="divKartice" v-if='karticaRezultati'>
        <div class="modelsWraper" v-if='models.length>0' >
            <div v-for="model in models">
                <modelcard :model=model @resp='odgovorJSON'></modelcard>
            </div>  
        </div>
        <div class='response2' v-if="models.length==0 && serv_resp==''">Nije pronadjen nijedan automobil koji moze da se rezervise u vremenskom periodu!</div>
        <div class="response2" id="odgovor" v-show="serv_resp!=''">@{{ serv_resp }}</div>
    </div>

    
        
</div>

{{-- Ova sekcija je predvidjena za nesto, na primer komentare ili ponude --}}
<div class="dodaci" id="vueDodaci">
        <h2 class='white padding_top_20'>Najbolje ponude</h2>
        <div class="flexRow">
            <div v-for="ad in ads">
                <adcard :model=ad></adcard>
            </div>
        </div>    
</div>

{{-- -develpment version --}}
<script src="{{ asset('/js/vue.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> --}}

{{-- prodaction version --}}
{{-- <script src="{{ asset('/js/vue.min.js') }}"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script> --}}

<script src="{{ asset('/js/biblioteka.js') }}"></script>
<script src="{{ asset('/js/vueBooking.js') }}"></script>
<script src="{{ asset('/js/validateForm.js') }}"></script>
<script src="{{ asset('/js/vueDodaci.js') }}"></script>

@endsection