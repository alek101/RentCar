@extends('mainPage')
@section('Page')

<form class="formZakazivanje">
    <div class="flexColumn">
        <div class="flexRow">
                @csrf 
                <input type="date" name="dateStart" id="start" value="{{$dateStart}}" hidden>
                <input type="date" name="dateEnd" id="end" value="{{$dateEnd}}" hidden>
        </div>
        <div class="flexRow">
            <label for="model">Model 
                    <select name="model" id="model">
                        @foreach ($models as $model)
                            <?php $pom=$cene[$model] ?>
                            {!! "<option value='$model'> $model - cena: $pom </option>" !!}
                        @endforeach
                    </select></label>
        
            <label for="ime"> Ime <input type="text" name="ime" id="ime" required></label>
            <label for="email">Email <input type="email" name="email" id="email" required></label>
            <label for="telefon">Telefon <input type="number" name="telefon" id="telefon"></label>
        </div>
        <div>
            <label for="comment"> Komentar <br><textarea name="comment" id="comment" cols="30" rows="10"></textarea></label>
        </div>
        <div><input type="submit" value="Posalji" id='dugme'></div>  
    </div>
</form>

<div class="response"></div>

<script>
        document.querySelector('#dugme').addEventListener('click',function(e)
        {
            e.preventDefault();

            let dateStart,dateEnd,model,ime,telefon,email,comment;

            dateStart=document.querySelector('#start').value;
            dateEnd=document.querySelector('#end').value;
            model=document.querySelector('#model').value;
            ime=document.querySelector('#ime').value;
            email=document.querySelector('#email').value;
            telefon=document.querySelector('#telefon').value || 000;
            comment=document.querySelector('#comment').value || 'no comment';
    
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
            // let fd = new FormData();
            // fd.append("dateStart", dateStart);
            // fd.append("_token", document.querySelector('input[name="_token"]').value);

            let opcije={
                method: "POST",
                body: JSON.stringify(niz),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json'   //BITNO!!!
                }
            }
    
            fetch('/rezervacija/posalji3',opcije)
                .then(resp=>resp.json())
                .then(jsn=>ispisi(jsn));
        })

        function ispisi(odgovor)
        {
            console.log(odgovor);

            if(odgovor==='Nije proslo!')
            {
                document.querySelector('.response').innerHTML="Rezervacija nije uspela, molimo pokusajte ponovo!";
            }
            else if(odgovor==='Los period!')
            {
                document.querySelector('.response').innerHTML=`Rezervacija nije uspela! Morate rezervisati barem jedan pun dan,
                 krajnji datum mora ici pre pocetnog datuma!`;
            }
            else
            {
                let r=`Uspesno ste rezervisali auto sa tablicama ${odgovor.tablice}. Sifra rezervacije je ${odgovor.id_rez}.`;
                document.querySelector('.response').innerHTML=r;
            }  
        }
    
    </script>
@endsection