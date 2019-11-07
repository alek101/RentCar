@extends('mainPage')
@section('Page')



<form >
    @csrf 
     <input type="date" name="dateStart" id="start" value="{{$dateStart}}" hidden>
     <input type="date" name="dateEnd" id="end" value="{{$dateEnd}}" hidden>
    Model 
    <select name="model" id="model">
        @foreach ($models as $model)
            <?php $pom=$cene[$model] ?>
            {!! "<option value='$model'> $model - cena: $pom </option>" !!}
        @endforeach
    </select>
    Ime <input type="text" name="ime" id="ime" required>
    Email <input type="email" name="email" id="email" required>
    Telefon <input type="number" name="telefon" id="telefon">
    Komentar <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
    <input type="submit" value="Posalji" id='dugme'>

</form>

<div class="response"></div>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
            
            axios(
                {
                    method:'post', 
                    url: '/rezervacija/posalji3',
                    data: niz,
                    headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    }
                }
            ).then(function(response)
                {
                    console.log('uspeo');
                    let odgovor=response.data;

                    if(odgovor==='Rezervacija: Neuspesna')
                    {
                        document.querySelector('.response').innerHTML=odgovor+" Proveriti vremenske intervale!";
                    }
                    else
                    {
                        let r=`Uspesno ste rezervisali auto sa tablicama ${odgovor.tablice}. Sifra rezervacije je ${odgovor.id_rez}.`;
                        document.querySelector('.response').innerHTML=r;
                    }  
                });
        })
    
    </script>
@endsection