@extends('index')
@section('PageF')

<div>
    <h1>Rezervišite vaš auto</h1>
    <h3>Najbolja ponuda u gradu. Bez učešća, ista za sve vozače, osiguranje uključeno u cenu. Rezervišite odmah!</h3>
</div>


<div class="flexRow linkA">
    <a href="#" id="aForma">1</a>
    <a href="#" id="aKartica">2</a>
    <a href="#" id="filterKartica">filter</a>
</div>

<div class="meniFilter flexRow cardDisapear">
    <label for="minCena">Minimalna Cena <input type="number" name="minCena" id="minCena"></label>
    <label for="maxCena">Maksimalna Cena <input type="number" name="maxCena" id="maxCena"></label>
</div>

<div class="divForma">
    <div class="formZakazivanje form">
            <div class="flexColumn">
                <div> @csrf </div>
                <div class="flexRow">
                    <label for="start" class="w50">Datum početka <input type="date" name="dateStart" id="start" value=""> </label>
                    <label for="end" class="w50">Datum završetka <input type="date" name="dateEnd" id="end" value="" ></label>
                </div>
                <div class="flexRow">
                
                    <label for="ime" class="w33"> Ime <input type="text" name="ime" id="ime" value="
                        @auth
                            {{ trim(Auth::user()->name) }}
                        @else
                            ''
                        @endauth 
                        "
                        required></label>
                    <label for="email" class="w33">Email <input type="email" name="email" id="email" value="
                        @auth
                            {{ Auth::user()->email }}
                        @else
                            ''
                        @endauth 
                        "
                        required></label>
                    <label for="telefon" class="w33">Telefon <input type="text" name="telefon" id="telefon" value="
                        @auth
                        {{ Auth::user()->phone }}
                        @else
                        '000000000'
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
    <div><a href="https://www.animatedimages.org/cat-cars-67.htm"><img src="https://www.animatedimages.org/data/media/67/animated-car-image-0124.gif" border="0" alt="animated-car-image-0124" /></a></div>
</div>
    

<div class="divKartice disapear">
    <div class="response2 hidden"></div>
    <div class="modelsWraper"></div>
</div>



<script>
    //ovo je za kartice
    function showForma()
    {
        document.querySelector('.divForma').classList.remove('disapear');
        document.querySelector('.divKartice').classList.add('disapear');
    }

    function showKartice()
    {
        document.querySelector('.divForma').classList.add('disapear');
        document.querySelector('.divKartice').classList.remove('disapear');
    }

    document.querySelector('#aForma').addEventListener('click',function(e)
        {
            e.preventDefault();
            showForma();
        })

    document.querySelector('#aKartica').addEventListener('click',function(e)
    {
        e.preventDefault();
        showKartice();
    })

    document.querySelector('#filterKartica').addEventListener('click',function(e)
    {
        e.preventDefault();
        // document.querySelector('.meniFilter').classList.toggle('hidden');
        document.querySelector('.meniFilter').classList.toggle('cardDisapear');
    });

    function filtirajPoCeni(min,max)
    {
        console.log('radi funkcija');
        min=document.querySelector('#minCena').value || 0;
        max=document.querySelector('#maxCena').value || Infinity;

        let pCena=[...document.querySelectorAll('.cenaOpisCard')];

        pCena.map(function(elCena)
        {
            let cenaIznos=parseFloat(elCena.getAttribute('data-cena'));
            if(cenaIznos>=min && cenaIznos<=max)
            {
                elCena.parentElement.parentElement.classList.remove('cardDisapear');
            }
            else
            {
                elCena.parentElement.parentElement.classList.add('cardDisapear');
            }
        });
    }
    
    document.querySelector('#minCena').addEventListener('change',function()
    {
        filtirajPoCeni();
    });

    document.querySelector('#maxCena').addEventListener('change',function()
    {
        filtirajPoCeni();
    });
    
    //ovo je za rezervacije

    let modelsWraper=document.querySelector('.modelsWraper');
    let responseDiv=document.querySelector('.response');
    let responseDiv2=document.querySelector('.response2');
    let dateStartInput=document.querySelector('#start');
    let dateEndInput=document.querySelector('#end');
    let imeInput=document.querySelector('#ime');
    let emailInput=document.querySelector('#email');
    let telefonInput=document.querySelector('#telefon')
    let danas=new Date();


    document.querySelector('.posalji').addEventListener('click',function(e)
        {
            e.preventDefault();

            let errors=[];

            let dateStart,dateEnd,model,ime,telefon,email,comment;

            
            dateStart=dateStartInput.value;
            if(dateStart=="")
            {
                errors.push('Mora da postoji pocetni datum!');
                dateStartInput.classList.add('errorBorder');
            }

            if(danas>=createDateDayFoward(dateStart))
            {
                errors.push('Ne mozete da rezervisete proslost!');
                dateStartInput.classList.add('errorBorder');
            }

            if(dateStart!="" && danas<createDateDayFoward(dateStart))
            {
                dateStartInput.classList.remove('errorBorder');
            }

            dateEnd=dateEndInput.value;
            if(dateEnd=="")
            {
                errors.push('Mora da postoji krajnji datum!'); 
                dateEndInput.classList.add('errorBorder');
            }
            else
            {
                dateEndInput.classList.remove('errorBorder');
            }

            if(createDate(dateStart)>=createDate(dateEnd))
            {
                errors.push('Krajnji datum mora da bude veci od pocetnog'); 
                dateStartInput.classList.add('errorBorder');
                dateEndInput.classList.add('errorBorder');
            }
            
            if(errors.length==0)
            {
                reset();
                let niz=
                {
                    dateStart:dateStart,
                    dateEnd:dateEnd,
                }
        
                console.log(niz);

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
                    .then(jsn=>ispisi(jsn));
            }
            else
            {
                errorsPrint(errors);
            }
            
        });


        function ispisi(json)
        {
            modelsWraper.innerHTML="";
            console.log("json koji je stigao: ",json);
            //proveravamo da li je json ,,prazan"
            if(json.unique_models.length>0)
            {
                for(let model of json.unique_models )
                {
                    let card=madeCard(model,json);
                    modelsWraper.appendChild(card);
                }
            }
            else
            {
                let r="Nije pronadjen nijedan automobil koji moze da se rezervise u vremnskom periodu!";
                let dd=makeElement('div',{text:r,className:'response2'});
                modelsWraper.append(dd);
            }
            
            showKartice();
        }
        
        function madeCard(model,json)
        {
            let d=makeElement('div',{text:null,className:"card"});
            let pic=makeElement('img',{src:json.podaci[model].slika,alt:'nema',className:'slicica'});
            let dm=makeElement('div',{text:null,className:"opis"});
                let p1=makeElement('p',{text:model,className:"modelCardName"});
                let p2=makeElement('p',{text:`<img class='icon' src='{!! asset('/images/icons/solid--car-gears.svg') !!}' alt='Tip Menjaca: '>
                 ${json.podaci[model].Tip_menjaca}`});
                let row2=makeElement('div',{className:'flexRow'});
                let p3=makeElement('p',{text:`<img class='icon' src='{!! asset('/images/icons/solid--car-door.svg') !!}' alt='Broj Vrata: '> 
                ${json.podaci[model].Broj_vrata}`});
                let p4=makeElement('p',{text:`<img class='icon' src='{!! asset('/images/icons/solid--car-seat.svg') !!}' alt='Broj Sedišta: '>
                ${json.podaci[model].Broj_sedista}`});
                let p5=makeElement('p',{text:`<img class='icon' src='{!! asset('/images/icons/solid--big-bag.svg') !!}' alt='Broj Torbi: '>
                ${json.podaci[model].Broj_torbi}`});
                row2.append(p3,p4,p5);
                let cena=formatBroja(json.cene[model]);
                let p6=makeElement('p',{text:`Cena: ${cena}`,className:'cenaOpisCard'});
                p6.setAttribute('data-cena',cena);
                let button=makeElement('button',{text:'Rezerviši',className:'dugmeRezervisi'});
                    button.addEventListener('click',function(e)
                    {
                        let errors=[];

                        let dateStart,dateEnd,ime,telefon,email,comment;

                        

                        dateStart=dateStartInput.value;
                        if(dateStart=="")
                        {
                            errors.push('Mora da postoji pocetni datum!');
                            dateStartInput.classList.add('errorBorder');
                        }

                        if(danas>=createDateDayFoward(dateStart))
                        {
                            errors.push('Ne mozete da rezervisete proslost!');
                            dateStartInput.classList.add('errorBorder');
                        }

                        if(dateStart!="" && danas<createDateDayFoward(dateStart))
                        {
                            dateStartInput.classList.remove('errorBorder');
                        }
                        
                        dateEnd=dateEndInput.value;
                        if(dateEnd=="")
                        {
                            errors.push('Mora da postoji krajnji datum!'); 
                            dateEndInput.classList.add('errorBorder');
                        }
                        else
                        {
                            dateEndInput.classList.remove('errorBorder');
                        }

                        if(createDate(dateStart)>=createDate(dateEnd))
                        {
                            errors.push('Krajnji datum mora da bude veci od pocetnog'); 
                            dateStartInput.classList.add('errorBorder');
                            dateEndInput.classList.add('errorBorder');
                        }

                        ime=imeInput.value;
                        if(ime=="")
                        {
                           errors.push('Mora da unese ime!'); 
                           imeInput.classList.add('errorBorder');
                        }
                        else
                        {
                            imeInput.classList.remove('errorBorder');
                        }
                         

                        email=emailInput.value;
                        if(email=="")
                        {
                          errors.push('Mora da se unese email!');
                          emailInput.classList.add('errorBorder'); 
                        }
                        else
                        {
                            emailInput.classList.remove('errorBorder'); 
                        }
                         

                        if(!validateEmail(email))
                        {
                           errors.push('Email nije validan!'); 
                           emailInput.classList.add('errorBorder'); 
                        }
                        else
                        {
                            emailInput.classList.remove('errorBorder'); 
                        }
                         
                        telefon=telefonInput.value;
                        console.log('telefon',telefon);
                        if(telefon=="")
                        {
                            errors.push('Telefon nije validan!'); 
                            telefonInput.classList.add('errorBorder'); 

                        }
                        else
                        {
                            telefonInput.classList.remove('errorBorder'); 
                        }

                        telefon-parseInt(telefon);
                        console.log('isNan',isNaN(telefon));
                        if(isNaN(telefon))
                        {
                            errors.push('Telefon mora da bude broj!'); 
                            telefonInput.classList.add('errorBorder'); 

                        }
                        else
                        {
                            telefonInput.classList.remove('errorBorder'); 
                        }

                        if(telefon<=9999999)
                        {
                            errors.push('Telefon mora da ima 8 cifara!'); 
                            telefonInput.classList.add('errorBorder'); 

                        }
                        else
                        {
                            telefonInput.classList.remove('errorBorder'); 
                        }


                        comment=document.querySelector('#comment').value || 'no comment';
                
                        if (errors.length==0)
                        {
            
                            let niz=
                            {
                                dateStart:dateStart,
                                dateEnd:dateEnd,
                                model:model,
                                ime:ime,
                                email:email,
                                telefon:telefon,
                                comment:comment  
                            }
                
                            console.log(niz);
                            
                            let opcije={
                                method: "POST",
                                body: JSON.stringify(niz),
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                    'Content-Type': 'application/json'   //BITNO!!!
                                }
                            }
                    
                            fetch('/zakazi/makeBookingWithFetch',opcije)
                                .then(resp=>resp.json())
                                .then(jsn=>odgovor(jsn))
                                .then(reset());
                        }
                        else
                        {
                            errorsPrint(errors);
                        }
                        
                    });

            dm.append(p1,p2,row2,p6);
            
            
            d.append(pic,dm,button);
            
            return d;
        }

        function reset()
        {
            modelsWraper.innerHTML="";
            responseDiv.innerHTML="";
            responseDiv.classList.add('hidden');
            responseDiv2.innerHTML="";
            responseDiv2.classList.add('hidden');
        }

        function errorsPrint(errors)
        {
            console.log(errors);
            
            responseDiv.innerHTML="";
            responseDiv.classList.remove('hidden');
            responseDiv2.innerHTML="";
            responseDiv2.classList.remove('hidden');
            let fr=document.createDocumentFragment();
            let fr2=document.createDocumentFragment();

            for(let error of errors)
            {
                let p=makeElement('p',{text:error,className:"errorP"});
                let p2=makeElement('p',{text:error,className:"errorP"});
                fr.append(p);
                fr2.append(p2);
            }
            responseDiv.append(fr);
            responseDiv2.append(fr2);
            showForma();
        }

        function makeElement(type="div",settings={
        text: "",
        className:"",
        src:"",
        alt:"There is no Picture aveilable",
        width:0,
        height:0,
        href:"",
        })
        {

            settings.text=settings.text || "";
            settings.className=settings.className || "";
            settings.src=settings.src || "";
            settings.alt=settings.alt || "There is no Picture aveilable";
            settings.href=settings.href || "";
        let element=document.createElement(type);
            element.className=settings.className;
        switch(type){
            case "img":{
                    element=document.createElement('img');
                    element.className=settings.className;
                    element.src=settings.src;
                    element.alt=settings.alt;
                    if(settings.width>0 && !isNaN(Number(settings.width))) element.style.width=settings.width+"px";
                    if(settings.height>0 && !isNaN(Number(settings.height))) element.style.height=settings.height+"px";
            }; break;
            case "a":{
                    element.href=settings.href;
                    element.innerHTML=settings.text;
            };break;
            default:{
                    element.innerHTML=settings.text;
            }
        }       
        return element;
    }

    function formatBroja(num){
        return new Intl.NumberFormat('sr-RS',{minimumFractionDigits: 2}).format(num);
    }

    function odgovor(odgovor)
        {
            responseDiv.classList.remove('hidden');
            console.log(odgovor);

            if(odgovor==='Nije proslo!')
            {
                responseDiv.innerHTML="Rezervacija nije uspela, molimo pokusajte ponovo!";
                showForma(); 
            }
            else if(odgovor==='Los period!')
            {
                responseDiv.innerHTML=`Rezervacija nije uspela! Morate rezervisati barem jedan pun dan,
                 krajnji datum mora ici pre pocetnog datuma!`;
                 showForma(); 
            }
            else
            {
                let r=`Uspesno ste rezervisali auto sa tablicama ${odgovor.tablice}. Sifra rezervacije je ${odgovor.id_rez}.`;
                responseDiv.innerHTML=r;
                responseDiv2.innerHTML=r;
                let dd=makeElement('div',{text:r,className:'response2'});
                modelsWraper.append(dd);
            } 
        }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function createDate(inputDate)
    {
        inputDate=inputDate.split('-');
        return new Date(inputDate[0],inputDate[1]-1,inputDate[2]);
    }

    //da bismo mogli da rezervisemo danas, mi blefiramo da je danas u stvari sutra
    function createDateDayFoward(inputDate)
    {
        inputDate=inputDate.split('-');
        let time=new Date(inputDate[0],inputDate[1]-1,inputDate[2]);
        console.log('time',time);
        time=time.setTime(time.getTime()+(24*60*60*1000));
        console.log('time',time);
        return time;
    }

</script>

@endsection