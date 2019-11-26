function validateForm(errors,dateStart,dateEnd,ime,telefon,email,comment)
{
    console.log('validacija: ',errors,dateStart,dateEnd,ime,telefon,email,comment);
    let danas=new Date();
    let dateStartInput=document.querySelector('#dateStartGroup');
    let dateEndInput=document.querySelector('#dateEndGroup');
    let imeInput=document.querySelector('#imeLabel');
    let emailInput=document.querySelector('#emailLabel');
    let telefonInput=document.querySelector('#telefonLabel');

    if(dateStart=="" || dateStart==null)
    {
        errors.push('Mora da postoji pocetni datum!');
        dateStartInput.classList.add('errorBorder');
    }
 
    if(dateStart!=null && danas>=pf.createDateDayFoward(dateStart))
    {
        errors.push('Ne mozete da rezervisete proslost!');
        dateStartInput.classList.add('errorBorder');
    }
 
    if(dateStart!=null && danas<pf.createDateDayFoward(dateStart))
    {
        dateStartInput.classList.remove('errorBorder');
    }
 
    if(dateEnd=="" || dateEnd==null)
    {
        errors.push('Mora da postoji krajnji datum!'); 
        dateEndInput.classList.add('errorBorder');
    }
    else
    {
        dateEndInput.classList.remove('errorBorder');
    }
 
    if(dateEnd!=null && pf.createDate(dateStart)>=pf.createDate(dateEnd))
    {
        errors.push('Krajnji datum mora da bude veci od pocetnog'); 
        dateStartInput.classList.add('errorBorder');
        dateEndInput.classList.add('errorBorder');
    }

   if(ime=="" || ime==null)
   {
      errors.push('Mora da unese ime!'); 
      imeInput.classList.add('errorBorder');
   }
   else
   {
       imeInput.classList.remove('errorBorder');
   }
    
   if(email=="" || email==null)
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
    
   if(telefon!=null && telefon!="")
   {
     telefon=telefon.replace("+",99);  
     telefon=parseInt(telefon);
   }
   
   if(telefon=="" || telefon==null)
   {
       errors.push('Telefon nije validan!'); 
       telefonInput.classList.add('errorBorder'); 

   }
   else
   {
       telefonInput.classList.remove('errorBorder'); 
   }

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

   if (comment!=null && comment!="")
   {
       comment=comment.slice(0,255);
   }
   
   return errors;
}

