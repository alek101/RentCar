@extends('mainPage')
@section('Page')

<form method="POST" action="/rezervacijeInfo/extendReservation" class="sveRez">
    <div class="flexColumn">
        <div>@csrf</div>
        <div class="flexRow">
            <label for="rez_id">ID Rezervacije <input type="num" name="rez_id" id="rez_id" value="{{ $id }}" readonly required></label>
            <label for="brojDana">Broj dana <input type="num" name="brojDana" id="brojDana" required></label>
        </div>
        <div><input type="submit" value="Posalji" id="dugme"> </div>
    </div>
</form>

<div class="response"></div>

<script>
        document.querySelector('#dugme').addEventListener('click',function(e)
        {
            e.preventDefault();

           let id=document.querySelector('#rez_id').value;
            let brojDana=document.querySelector('#brojDana').value;
            
    
            let niz=
            {
                id:id,
                brojDana:brojDana
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
    
            fetch('/rezervacijeInfo/extendReservation',opcije)
                .then(resp=>resp.text())
                .then(txt=>ispisi(txt));
        })

        function ispisi(odgovor)
        {          
            document.querySelector('.response').innerHTML=odgovor;
        }
    
    </script>

@endsection