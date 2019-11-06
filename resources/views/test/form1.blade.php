@extends('mainPage')
@section('Page')



<form >
    {{-- @csrf      --}}
    <input type="submit" value="Posalji" id='dugme'>
</form>

<div class="response"></div>

<script>
        document.querySelector('#dugme').addEventListener('click',function(e)
        {
            e.preventDefault();

            // let opcije={
            //     method: "GET",
            //     headers: {
            //         // 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            //     }
            // }
    
            // fetch('/test/posalji1',opcije)
            //     .then(resp=>resp.json())
            //     .then(jsn=>napravi(jsn,resDiv));

            fetch('/test/posalji1')
                .then(resp=>resp.json())
                .then(jsn=>napravi(jsn,resDiv));


        })

        let resDiv=document.querySelector('.response');

        function napravi(json,div)
        {
            for(red of json)
            {
                console.log(red);
                let l=JSON.stringify(red);
                let p=document.createElement('p');
                p.append(l);
                div.append(p);
            }
        }
    
    </script>
@endsection