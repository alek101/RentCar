//komponenta ide pre roditelja
//komponenta sluzi da napravi kartice sa automobilima za rezervacije
Vue.component('modelcard',
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
                <p class="cenaOpisCard" :data-cena=model.cena>Cena: {{ model.cena }}</p>
            </div>
            <button class="dugmeRezervisi" @click='rezervisi'>Rezerviši</button>
        </div>
        `,
        // `<div>{{ model }}</div>`,
        
        methods:
        {
           rezervisi()
           {
            console.log('poslat niz', this.model.niz);
            let opcije={
                method: "POST",
                body: JSON.stringify(this.model.niz),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json'   //BITNO!!!
                }
            }
            //emituje se odgovor kako bi metoda u roditelju mogla da ga ostampa
            fetch('/zakazi/makeBookingWithFetch',opcije)
                .then(resp=>resp.json())
                .then(jsn=>this.$emit('resp',jsn))
           },
        },  
})

let vueBooking=new Vue(
    {
        el:"#vueSelector",
        data:
        {
            //lazni datumi
            dateStartNew:null,
            dateEndNew:null,
            //podaci iz forme
            dateStartModel:null,
            dateEndModel:null,
            imeModel:null,
            emailModel:null,
            telefonModel:null,
            commentModel:null || 'no commment',
            //druge promenljive
            errors:[],
            karticaForma:true,
            karticaRezultati:false,
            filter:false,
            minCena:null || 0,
            maxCena:null || 100000,
            models:[],
            csrf:null,
            serv_resp:"",
        },
        
        methods:
        {
            //sledeca 4 su za kartice preko datuma
            //new su oni napisani po naschki, a model su oni koji se zaista salju
            inputStartDate()
            {
                this.dateStartNew=pf.dateToSerbianFormat(this.dateStartModel);
            },

            inputEndDate()
            {
                this.dateEndNew=pf.dateToSerbianFormat(this.dateEndModel);
            },

            outputStartDate()
            {
                this.dateStartModel=null;
            },

            outputEndDate()
            {
                this.dateEndModel=null;
            },

            //za prikazivanje forme ili datuma
            kartica1()
            {
                this.karticaForma=true;
                this.karticaRezultati=false;
            },

            kartica2()
            {
                this.karticaForma=false;
                this.karticaRezultati=true;
            },

            //prikazivanje filtera
            filterUklj()
            {
                this.filter=!this.filter;
            },

            //prvi uput ka serveru
            prviUput()
            {
                this.serv_resp="";
                this.errors=[];
                this.errors=validateForm(this.errors,this.dateStartModel,this.dateEndModel,this.imeModel,this.telefonModel,this.emailModel,this.commentModel);
                if(this.errors.length==0)
                {
                    let niz=
                    {
                        dateStart:this.dateStartModel,
                        dateEnd:this.dateEndModel,
                    }
            
                    console.log('vremenski period',niz);

                    let opcije={
                        method: "POST",
                        body: JSON.stringify(niz),
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Content-Type': 'application/json'   //BITNO!!!
                        }
                    }
            
                    fetch('/zakazi/makeJSONforBooking',opcije)
                        .then(resp=>resp.json())
                        .then(jsn=>this.ispisi(jsn));
                        }
            },

            //prvi ispis
            ispisi(jsn)
            {
                console.log('json return:', jsn);
                this.kartica2();
                for (model of jsn.unique_models)
                {
                    let modelPom=jsn.podaci[model];
                    modelPom.cena=pf.formatBroja(jsn.cene[model]);
                    let niz={
                        dateStart:this.dateStartModel,
                        dateEnd:this.dateEndModel,
                        model:modelPom.Model,
                        ime:this.imeModel,
                        email:this.emailModel,
                        telefon:this.telefonModel,
                        comment:this.commentModel, 
                        }
                    modelPom.niz=niz;    
                    this.models.push(modelPom);
                }
            },

            //filter cena
            filterCena()
            {
                let pCena=[...document.querySelectorAll('.cenaOpisCard')];
                let min=parseFloat(this.minCena);
                let max=parseFloat(this.maxCena);

                pCena.map(function(elCena)
                {
                    let cenaIznos=parseFloat(elCena.getAttribute('data-cena'));
                    if(cenaIznos>=min && cenaIznos<=max)
                    {
                        elCena.parentElement.parentElement.parentElement.classList.remove('cardDisapear');
                    }
                    if(cenaIznos<min || cenaIznos>max)
                    {
                        elCena.parentElement.parentElement.parentElement.classList.add('cardDisapear');
                    }
                });
            },

            //odgovor servera na rezervaciju
            odgovorJSON(odgovor)
            {
                console.log('odgovor servera', odgovor);
                if(odgovor==='Nije proslo!')
                {
                    this.serv_resp="Rezervacija nije uspela, molimo pokusajte ponovo!";
                    
                }
                else if(odgovor==='Los period!')
                {
                    this.serv_resp=`Rezervacija nije uspela! Morate rezervisati barem jedan pun dan,
                    krajnji datum mora ici pre pocetnog datuma!`; 
                }
                else
                {
                    this.serv_resp=`Uspesno ste rezervisali auto sa tablicama ${odgovor.tablice}. Sifra rezervacije je ${odgovor.id_rez}.`;
                    this.models=[];
                } 
            }
        },
    }
);



