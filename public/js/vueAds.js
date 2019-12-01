//dodaci su u stvari Ads
Vue.component('adcard', 
{
    props:{
        model:
        {
            type:Object,
            required: true,
        }
    },
    template:
        `
        <div class="cardAd">
            <img class="slicicaAd" :src=model.slika alt="nema">
            <div class="opisAd">
                <p class="modelCardName">{{ model.Model }}</p>
                <p class=""><img class="icon" src="/images/icons/solid--car-gears.svg" alt="Tip Menjaca: ">{{ model.Tip_menjaca }}</p>
                <div class="flexRow">
                    <p class=""><img class="icon" src="/images/icons/solid--car-door.svg" alt="Broj Vrata: "> {{ model.Broj_vrata }}</p>
                    <p class=""><img class="icon" src="/images/icons/solid--car-seat.svg" alt="Broj Sedišta: ">{{ model.Broj_sedista }}</p>
                    <p class=""><img class="icon" src="/images/icons/solid--big-bag.svg" alt="Broj Torbi: ">{{ model.Broj_torbi }}</p>
                </div>
                <p class="cenaOpisCard">Cena: {{ model.cena }} za {{ model.brojDana }} {{ model.daniNaziv }}</p>
            </div>
        </div>
        `,
})

let vueAds=new Vue({
    el:"#vueAds",
    data:
    {
        ads:[],
    },
        
    methods: 
    {
        callData()
        {
            // fetch('/klient/jsonAds')
            fetch('/klient/jsonAdsFixedNumber')
            .then(res=>res.json())
            // this se odnosi na data 
            .then(json=>this.ads=daniNaziv(json))
        },
    },

    //ovo znaci da treba pozvati funkciju pre renovanja virtuelnog DOM-a
    //https://vuejs.org/v2/api/#beforeMount
    beforeMount() {
        this.callData();
    },
})

//dodaje da li je dan ili dani u nazivu
function daniNaziv(json)
{
    for (ad of json)
    {
        if(ad.brojDana==1)
        {
            ad['daniNaziv']='dan';
        }
        else
        {
            ad['daniNaziv']='dana'; 
        }
    }

    return json;
}
