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
        <div class="card">
            <img class="slicica" :src=model.slika alt="nema">
            <div class="opis">
                <p class="modelCardName">{{ model.Model }}</p>
                <p class=""><img class="icon" src="/images/icons/solid--car-gears.svg" alt="Tip Menjaca: ">{{ model.Tip_menjaca }}</p>
                <div class="flexRow">
                    <p class=""><img class="icon" src="/images/icons/solid--car-door.svg" alt="Broj Vrata: "> {{ model.Broj_vrata }}</p>
                    <p class=""><img class="icon" src="/images/icons/solid--car-seat.svg" alt="Broj Sedišta: ">{{ model.Broj_sedista }}</p>
                    <p class=""><img class="icon" src="/images/icons/solid--big-bag.svg" alt="Broj Torbi: ">{{ model.Broj_torbi }}</p>
                </div>
                <p class="cenaOpisCard">Cena: {{ model.cena }} za 7 dana</p>
            </div>
        </div>
        `,
})

let vueDodaci=new Vue({
    el:"#vueDodaci",
    data:
    {
        ads:
        [{"Model":"PEUGEOT 308 1.6 HDI","Klasa":"srednja","Tip_menjaca":"automatski","Broj_sedista":5,"Broj_vrata":4,"Broj_torbi":4,"slika":"/images/peugeot-308-1-6-hdi.jpg","opis":"nema","cena":"70,00","niz":{"dateStart":"2019-11-29","dateEnd":"2019-12-01","model":"PEUGEOT 308 1.6 HDI","ime":"Alek","email":"Alekp111@Gmail.com","telefon":"64123456","comment":"no commment"}},{"Model":"CITROEN C3 1.4 HDI","Klasa":"mala","Tip_menjaca":"automatski","Broj_sedista":4,"Broj_vrata":4,"Broj_torbi":3,"slika":"/images/citroen-c3-1-4-hdi.jpg","opis":"nema","cena":"50,00","niz":{"dateStart":"2019-11-29","dateEnd":"2019-12-01","model":"CITROEN C3 1.4 HDI","ime":"Alek","email":"Alekp111@Gmail.com","telefon":"64123456","comment":"no commment"}},{"Model":"SEAT IBIZA 1.2 TDI","Klasa":"mala","Tip_menjaca":"manuelni","Broj_sedista":4,"Broj_vrata":4,"Broj_torbi":1,"slika":"/images/seat-ibiza-1-2-tdi.jpg","opis":"nema","cena":"64,00","niz":{"dateStart":"2019-11-29","dateEnd":"2019-12-01","model":"SEAT IBIZA 1.2 TDI","ime":"Alek","email":"Alekp111@Gmail.com","telefon":"64123456","comment":"no commment"}},{"Model":"PEUGEOT 208 1.4 HDI","Klasa":"mala","Tip_menjaca":"manuelni","Broj_sedista":4,"Broj_vrata":4,"Broj_torbi":2,"slika":"/images/peugeot-208-1-4-hdi.jpg","opis":"nema","cena":"58,00","niz":{"dateStart":"2019-11-29","dateEnd":"2019-12-01","model":"PEUGEOT 208 1.4 HDI","ime":"Alek","email":"Alekp111@Gmail.com","telefon":"64123456","comment":"no commment"}},{"Model":"FORD C MAX 2.0 TDCI","Klasa":"velika","Tip_menjaca":"automatski","Broj_sedista":5,"Broj_vrata":5,"Broj_torbi":8,"slika":"/images/ford-c-max-2-0-tdci.jpg","opis":"nema","cena":"74,00","niz":{"dateStart":"2019-11-29","dateEnd":"2019-12-01","model":"FORD C MAX 2.0 TDCI","ime":"Alek","email":"Alekp111@Gmail.com","telefon":"64123456","comment":"no commment"}},{"Model":"SEAT LEON CARAVAN 1.6 TDI","Klasa":"srednja","Tip_menjaca":"automatski","Broj_sedista":5,"Broj_vrata":4,"Broj_torbi":6,"slika":"/images/seat-leon-karavan-1-6-tdi.jpg","opis":"nema ttt","cena":"66,00","niz":{"dateStart":"2019-11-29","dateEnd":"2019-12-01","model":"SEAT LEON CARAVAN 1.6 TDI","ime":"Alek","email":"Alekp111@Gmail.com","telefon":"64123456","comment":"no commment"}}]
    }
})