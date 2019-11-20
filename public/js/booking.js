 //ovo je za rezervacije

 //selektori
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

         let dateStart,dateEnd;

         dateStart=dateStartInput.value;
         dateEnd=dateEndInput.value;

         errors=validateDate(errors,dateStart,dateEnd);
         
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
             let dd=pf.makeElement('div',{text:r,className:'response2'});
             modelsWraper.append(dd);
         }
         
         showKartice();
     }
     
     function madeCard(model,json)
     {
         let d=pf.makeElement('div',{text:null,className:"card"});
         let pic=pf.makeElement('img',{src:json.podaci[model].slika,alt:'nema',className:'slicica'});
         let dm=pf.makeElement('div',{text:null,className:"opis"});
             let p1=pf.makeElement('p',{text:model,className:"modelCardName"});
             //posto je sada ovo cista js funkcija, i ne zove se iz blade-a, src se pise normalno, a ne kao {{ asset() }}
             let p2=pf.makeElement('p',{text:`<img class='icon' src='/images/icons/solid--car-gears.svg' alt='Tip Menjaca: '>
              ${json.podaci[model].Tip_menjaca}`});
             let row2=pf.makeElement('div',{className:'flexRow'});
             let p3=pf.makeElement('p',{text:`<img class='icon' src='/images/icons/solid--car-door.svg' alt='Broj Vrata: '> 
             ${json.podaci[model].Broj_vrata}`});
             let p4=pf.makeElement('p',{text:`<img class='icon' src='/images/icons/solid--car-seat.svg' alt='Broj Sedišta: '>
             ${json.podaci[model].Broj_sedista}`});
             let p5=pf.makeElement('p',{text:`<img class='icon' src='/images/icons/solid--big-bag.svg' alt='Broj Torbi: '>
             ${json.podaci[model].Broj_torbi}`});
             row2.append(p3,p4,p5);
             let cena=pf.formatBroja(json.cene[model]);
             let p6=pf.makeElement('p',{text:`Cena: ${cena}`,className:'cenaOpisCard'});
             p6.setAttribute('data-cena',cena);
             let button=pf.makeElement('button',{text:'Rezerviši',className:'dugmeRezervisi'});
                 button.addEventListener('click',function(e)
                 {
                     let errors=[];

                     let dateStart,dateEnd,ime,telefon,email,comment;

                    dateStart=dateStartInput.value;
                    dateEnd=dateEndInput.value;
                    ime=imeInput.value;
                    telefon=telefonInput.value;
                    email=emailInput.value;
                    comment=document.querySelector('#comment').value || 'no comment';

                    errors=validateForm(errors,dateStart,dateEnd,ime,telefon,email,comment)
  
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

     function validateDate(errors,dateStart,dateEnd)
     {
        if(dateStart=="")
        {
            errors.push('Mora da postoji pocetni datum!');
            dateStartInput.classList.add('errorBorder');
        }

        if(danas>=pf.createDateDayFoward(dateStart))
        {
            errors.push('Ne mozete da rezervisete proslost!');
            dateStartInput.classList.add('errorBorder');
        }

        if(dateStart!="" && danas<pf.createDateDayFoward(dateStart))
        {
            dateStartInput.classList.remove('errorBorder');
        }

        if(dateEnd=="")
        {
            errors.push('Mora da postoji krajnji datum!'); 
            dateEndInput.classList.add('errorBorder');
        }
        else
        {
            dateEndInput.classList.remove('errorBorder');
        }

        if(pf.createDate(dateStart)>=pf.createDate(dateEnd))
        {
            errors.push('Krajnji datum mora da bude veci od pocetnog'); 
            dateStartInput.classList.add('errorBorder');
            dateEndInput.classList.add('errorBorder');
        }

        return errors;
     }

     function validateForm(errors,dateStart,dateEnd,ime,telefon,email,comment)
     {
        errors=validateDate(errors,dateStart,dateEnd);

        if(ime=="")
        {
           errors.push('Mora da unese ime!'); 
           imeInput.classList.add('errorBorder');
        }
        else
        {
            imeInput.classList.remove('errorBorder');
        }
         
        if(email=="")
        {
          errors.push('Mora da se unese email!');
          emailInput.classList.add('errorBorder'); 
        }
        else
        {
            emailInput.classList.remove('errorBorder'); 
        }
         
        if(!pf.validateEmail(email))
        {
           errors.push('Email nije validan!'); 
           emailInput.classList.add('errorBorder'); 
        }
        else
        {
            emailInput.classList.remove('errorBorder'); 
        }
         
        if(telefon=="")
        {
            errors.push('Telefon nije validan!'); 
            telefonInput.classList.add('errorBorder'); 

        }
        else
        {
            telefonInput.classList.remove('errorBorder'); 
        }

        telefon=parseInt(telefon);

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

        if(comment=="SERVIS")
        {
            comment+="_kupac";
        }

        return errors;
     }

     function errorsPrint(errors)
     {
         console.log(errors);
         
         modelsWraper.innerHTML="";
         responseDiv.innerHTML="";
         responseDiv.classList.remove('hidden');
         responseDiv2.innerHTML="";
         responseDiv2.classList.remove('hidden');
         let fr=document.createDocumentFragment();
         let fr2=document.createDocumentFragment();

         for(let error of errors)
         {
             let p=pf.makeElement('p',{text:error,className:"errorP"});
             let p2=pf.makeElement('p',{text:error,className:"errorP"});
             fr.append(p);
             fr2.append(p2);
         }
         responseDiv.append(fr);
         responseDiv2.append(fr2);
         showForma();
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
             let dd=pf.makeElement('div',{text:r,className:'response2'});
             modelsWraper.append(dd);
         } 
     }