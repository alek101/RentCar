@extends('mainPage')
@section('Page')

<h3>Za produženje registracije, izaberite tip.</h3>

<form method="POST" action="/servis/endServis" class='formZakazivanje'>
    <div class="flexColumn">
        <div>@csrf</div>
        
        <div class="flexRow">
            <label for="id">Broj Šasije <input type="text" name='id' value="<?=$id?>" id="id" readonly required></label>
        </div>
        <div class="flexRow">
            <label for="tip">
                Tip radova: <br> <select name="tip" id="tip">
                            <option value="mali">Mali Servis</option>
                            <option value="veliki">Veliki Servis</option>
                            <option value="registracija">Registracija</option>
                    </select>
            </label>
        </div>
        <div class="flexRow ser">
            <label for="datum">
                Datum Servisa <input type="date" name="datum" id="datum" value='<?php echo date("Y-m-d")?>'>
            </label>
        </div> 

        <div class="flexRow reg cardDisapear">       
            <label for="registracija">
                Novo Važanje Registracije <input type="date" name="registracija" id="registracija" value=''>
            </label>
        </div>
        <div class="flexRow ser2">
            <label for="um">Ulje motora<input type="checkbox" id="um" class='inputCheckBox'></label>
            <label for="fut">Filter ulja motora<input type="checkbox" id="fut" class='inputCheckBox'></label>
            <label for="fg">Filter goriva<input type="checkbox" id="fg" class='inputCheckBox'></label>
            <label for="fv">Filter vazduha<input type="checkbox" id="fv" class='inputCheckBox'></label>
            <label for="fk">Filter kabine<input type="checkbox" id="fk" class='inputCheckBox'></label>
        </div>
        
        
        <div><label for="opis" class="labelOpis">  Opis radova: <br> <textarea name="opis" id="opis" cols="30" rows="10"></textarea></label></div>
        
        
        <div class="flexRow">
            <div><input type="submit" value="Pošalji" id="dugme"></div>
        </div>
        
        
    </div>
    
</form>

<script>

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


</script>

@endsection