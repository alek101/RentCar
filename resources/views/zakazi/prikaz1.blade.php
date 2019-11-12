@extends('index')
@section('PageF')

<div class="flexRow linkA">
    <a href="#" id="aForma">Forma</a>
    <a href="#" id="aKartica">Ponude</a>
</div>


<div class="divForma">
    <div class="formZakazivanje form">
            <div class="flexColumn">
                <div> @csrf </div>
                <div class="flexRow">
                    <label for="start">Datum pocetka <input type="date" name="dateStart" id="start" value=""> </label>
                    <label for="end">Datum zavrsetka <input type="date" name="dateEnd" id="end" value="" ></label>
                </div>
                <div class="flexRow">
                
                    <label for="ime"> Ime <input type="text" name="ime" id="ime" required></label>
                    <label for="email">Email <input type="email" name="email" id="email" required></label>
                    <label for="telefon">Telefon <input type="number" name="telefon" id="telefon" placeholder="000"></label>
                </div>
                <div>
                    <label for="comment"> Komentar <br><textarea name="comment" id="comment" cols="30" rows="10" placeholder="no comment"></textarea></label>
                </div>
                <div><button class='posalji'>Posalji uput</button></div>  
            </div>
        </div>
    <div class="response hidden"></div>
</div>
    

<div class="divKartice disapear">
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

    
    //ovo je za rezervacije

    let modelsWraper=document.querySelector('.modelsWraper');
    let responseDiv=document.querySelector('.response');


    document.querySelector('.posalji').addEventListener('click',function(e)
        {
            e.preventDefault();

            let errors=[];

            let dateStart,dateEnd,model,ime,telefon,email,comment;

            dateStart=document.querySelector('#start').value;
            if(dateStart=="") errors.push('Mora da postoji pocetni datum!');

            dateEnd=document.querySelector('#end').value;
            if(dateEnd=="") errors.push('Mora da postoji krajnji datum!');
            
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
        
                fetch('/zakazi/posalji1',opcije)
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
            // let div=modelsWraper;
            modelsWraper.innerHTML="";
            for(let model of json.unique_models )
            {
                let card=madeCard(model,json);
                modelsWraper.appendChild(card);
            }
            console.log(json);
            showKartice();
        }
        
        function madeCard(model,json)
        {
            let d=makeElement('div',{text:null,className:"card"});
            let pic=makeElement('img',{src:json.podaci[model].slika,alt:'nema',className:'slicica'});
            let dm=makeElement('div',{text:null,className:"opis"});
                let p1=makeElement('p',{text:model,className:"modelCardName"});
                let p2=makeElement('p',{text:`Tip menjaca: ${json.podaci[model].Tip_menjaca}`});
                let p3=makeElement('p',{text:`Broj vrata: ${json.podaci[model].Broj_vrata}`});
                let p4=makeElement('p',{text:`Broj Sedista: ${json.podaci[model].Broj_sedista}`});
                let p5=makeElement('p',{text:`Broj Torbi: ${json.podaci[model].Broj_torbi}`});
                let cena=formatBroja(json.cene[model]);
                let p6=makeElement('p',{text:`Cena: ${cena}`});
                let button=makeElement('button',{text:'Rezervisi',className:'dugmeRezervisi'});
                    button.addEventListener('click',function(e)
                    {
                        let errors=[];

                        let dateStart,dateEnd,ime,telefon,email,comment;

                        dateStart=document.querySelector('#start').value;
                        if(dateStart=="") errors.push('Mora da postoji pocetni datum!');

                        dateEnd=document.querySelector('#end').value;
                        if(dateEnd=="") errors.push('Mora da postoji krajnji datum!');

                        ime=document.querySelector('#ime').value;
                        if(ime=="") errors.push('Mora da unese ime!');

                        email=document.querySelector('#email').value;
                        if(email=="") errors.push('Mora da se unese email!');

                        telefon=document.querySelector('#telefon').value || 000;
                        comment=document.querySelector('#comment').value || 'no comment';
                
                        if (errors.length==0)
                        {
                            reset();
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
                    
                            fetch('/zakazi/posalji2',opcije)
                                .then(resp=>resp.json())
                                .then(jsn=>odgovor(jsn))
                                .then(reset());
                        }
                        else
                        {
                            errorsPrint(errors);
                        }
                        
                    });

            dm.append(p1,p2,p3,p4,p5,p6);
            
            
            d.append(pic,dm,button);
            
            return d;
        }

        function reset()
        {
            modelsWraper.innerHTML="";
            responseDiv.innerHTML="";
            responseDiv.classList.add('hidden');
        }

        function errorsPrint(errors)
        {
            console.log(errors);
            reset();
            responseDiv.classList.remove('hidden');
            let newDiv=makeElement('div',{text:"",className:"response2"});
            // let newDiv2=makeElement('div',{text:""});

            for(let error of errors)
            {
                let p=makeElement('p',{text:error,className:"errorP"});
                let p2=makeElement('p',{text:error,className:"errorP"});
                newDiv.append(p);
                responseDiv.append(p2);
            }
            modelsWraper.append(newDiv);
        }

        function makeElement(type="div",settings={
        text: null,
        className:"",
        src:"",
        alt:"There is no Picture aveilable",
        width:0,
        height:0,
        href:"",
        })
        {
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
            let div=responseDiv;
            let div2=modelsWraper;
            div.classList.remove('hidden');
            console.log(odgovor);

            if(odgovor==='Nije proslo!')
            {
                div.innerHTML="Rezervacija nije uspela, molimo pokusajte ponovo!";
                showForma(); 
            }
            else if(odgovor==='Los period!')
            {
                div.innerHTML=`Rezervacija nije uspela! Morate rezervisati barem jedan pun dan,
                 krajnji datum mora ici pre pocetnog datuma!`;
                 showForma(); 
            }
            else
            {
                let r=`Uspesno ste rezervisali auto sa tablicama ${odgovor.tablice}. Sifra rezervacije je ${odgovor.id_rez}.`;
                div.innerHTML=r;
                let divOdg=makeElement('div',{text:r,className:"response2"});
                div2.innerHTML="";
                div2.append(divOdg);
            } 
        }

</script>

@endsection