//menja izgled forme u zavisnosti da li radimo servis ili registrujemo vozilo
let select=document.querySelector('#tip');

document.querySelector('#tip').addEventListener('change',function()
{
    let selected=select.value;
    if(selected=="mali" || selected=="veliki")
    {
        document.querySelector('.ser').classList.remove('cardDisapear');
        document.querySelector('.ser2').classList.remove('cardDisapear');
        document.querySelector('.labelOpis').classList.remove('disapear');
        document.querySelector('.reg').classList.add('cardDisapear');
    }

    if(selected=='registracija')
    {
        document.querySelector('.ser').classList.add('cardDisapear');
        document.querySelector('.ser2').classList.add('cardDisapear');
        document.querySelector('.labelOpis').classList.add('disapear');
        document.querySelector('.reg').classList.remove('cardDisapear');
    }
})

//selectori check-boxova
let cb={
    um:document.querySelector('#um'),
    fut:document.querySelector('#fut'),
    fg:document.querySelector('#fg'),
    fv:document.querySelector('#fv'),
    fk:document.querySelector('#fk'),
}

let opis=document.querySelector('#opis');

function upisi(text)
{
    console.log('opis_upis',opis);
    opis.value+=text;
}

function ispisi(cut)
{
    console.log('opis_ispis',opis);
    //prima tekst
    let text=opis.value;
    //brise iz html-a
    opis.value="";
    //izbacuje visak iz teksta i pravi niz od ostatka
    text=text.split(cut);
    //spaja niz u celinu
    text=text.join("");
    //vraca u tekst
    upisi(text);
}

//klikom na check-boxove, upisujemo uobicajne radove tokom malog servisa
cb.um.addEventListener('change',function()
{
    if(cb.um.checked)
    {
        upisi(' Promenjeno je ulje motora. ');
    }
    else
    {
        ispisi(' Promenjeno je ulje motora. ');
    }
})

cb,fut.addEventListener('change',function()
{
    if(cb.fut.checked)
    {
        upisi(' Promenjen je fillter ulja motora. ');
    }
    else
    {
        ispisi(' Promenjen je fillter ulja motora. ');
    }
        
})

cb.fg.addEventListener('change',function()
{
    if(cb.fg.checked)
    {
        upisi(' Promenjen je filter goriva. ');
    }
    else
    {
        ispisi(' Promenjen je filter goriva. ');
    }
        
})

cb.fv.addEventListener('change',function()
{
    if(cb.fv.checked)
    {
        upisi(' Promenjen je filter vazduha. ');
    }
    else
    {
        ispisi(' Promenjen je filter vazduha. ');
    }
        
})

cb.fk.addEventListener('change',function()
{
    if(cb.fk.checked)
    {
        upisi(' Promenjen je filter kabine. ');
    }
    else
    {
        ispisi(' Promenjen je filter kabine. ');
    }
        
})