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
                let l=JSON.stringify(red);
                let p=document.createElement('p');
                p.append(l);
                div.append(p);
            }
        }

        window.addEventListener('click',function(e)
        {
            console.log(e);
        })

        window.addEventListener('scroll',function(e)
        {
            console.log(e);
        })

        let mouse=false;

        window.addEventListener('mousedown', function(e)
        {
            mouse=true;
            console.log(mouse);
        })

        window.addEventListener('mouseup', function(e)
        {
            mouse=false;
            console.log(mouse);
        })

        window.addEventListener('mousemove',function(e)
        {
            if(mouse)
            {
              console.log(event);   
            }
            
        })
    
    </script>
@endsection