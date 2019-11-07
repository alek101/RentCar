@extends('index')
@section('PageF')



<div class="formZakazivanje">
        <div class="flexColumn">
            <div>@csrf </div>
            <div class="flexRow">
                <label for="start">Datum pocetka <input type="date" name="dateStart" id="start" value=""> </label>
                <label for="end">Datum zavrsetka <input type="date" name="dateEnd" id="end" value="" ></label>
            </div>
            <div class="flexRow">
            
                <label for="ime"> Ime <input type="text" name="ime" id="ime" required></label>
                <label for="email">Email <input type="email" name="email" id="email" required></label>
                <label for="telefon">Telefon <input type="number" name="telefon" id="telefon"></label>
            </div>
            <div>
                <label for="comment"> Komentar <br><textarea name="comment" id="comment" cols="30" rows="10"></textarea></label>
            </div>
            <div><button class='posalji'>Posalji uput</button></div>  
        </div>
    </iv>

<div class="flexRow modelsWraper"></div>


<script>
    document.querySelector('.posalji').addEventListener('click',function(e)
        {
            e.preventDefault();

            let dateStart,dateEnd,model,ime,telefon,email,comment;

            dateStart=document.querySelector('#start').value;
            dateEnd=document.querySelector('#end').value;
            
    
            let niz=
            {
                dateStart:dateStart,
                dateEnd:dateEnd,
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
    
            fetch('/zakazi/posalji1',opcije)
                .then(resp=>resp.json())
                .then(jsn=>ispisi(jsn));
        });


        function ispisi(json)
        {
            let div=document.querySelector('.modelsWraper');
            for(let model of json.unique_models )
            {
                let card=madeCard(model,json);
                div.appendChild(card);
            }
            console.log(json);
            // console.log(json.unique_models);
        }
        
        function madeCard(model,json)
        {
            let d=document.createElement('div');
            d.innerHTML=model;
            return d;
        }

        


</script>

@endsection