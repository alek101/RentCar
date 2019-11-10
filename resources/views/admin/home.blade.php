@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($users);
@endphp --}}
<div class="margin_20"><label for="filter">Filter: <input type="text" id="filter" class='filter'></label></div>

<div class="prazan"></div>

<table>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>ChangeRole</th>
        <th>Remove</th>
        
    </tr>

    @foreach ($users as $user)
        @if ($user->role<100)
        {!! 
            "<tr>" .
    
                "<td>" .
                    $user->name
                    . "</td>".
    
                    "<td>" .
                    $user->email
                    . "</td>".
    
                    "<td>" .
                    $user->role
                    . "</td>"
    
                    ."<td> <a href='/admin/".$user->id."'>Change</td>"
    
                    
                    // ."<td> <a href='/admin/delete/".$user->id."'>Delete</td>"

                    ."<td><button class='obrisi' data-link='/admin/delete/$user->id'>Obrisi</button></td>"
                    
             . "</tr>";
            !!}
        @else
            {!! 
                "<tr>" .
        
                    "<td>" .
                        $user->name
                        . "</td>".
        
                        "<td>" .
                        $user->email
                        . "</td>".
        
                        "<td>" .
                        "Super Administrator"
                        . "</td>"
        
                        ."<td></td>"
        
                        
                        ."<td></td>"
                        
                . "</tr>";
                !!}
        @endif
        
    @endforeach
</table>

<script>
    //obrisi sa proverom
    let butoniObrisi=[...document.querySelectorAll('.obrisi')];
    butoniObrisi.map(b=>b.addEventListener('click', function()
    {
        let link=b.getAttribute('data-link');
            let div=document.createElement('div');
            div.className='kartica';
            div.innerHTML="<h3>Da li ste sigurni?</h3>";

            let div2=document.createElement('div');
            div2.className='flexRow';

            let rand=Math.floor(Math.random()*91)+10;
            div2.append('Upisite sledeci broj: ',rand);

            let div21=document.createElement('div');
            div21.className='flexRow';

            input=document.createElement('input');
            div21.append(input);

            let div3=document.createElement('div');
            div3.className='flexRow';

            let butY=document.createElement('button');
            butY.innerHTML="Da";
            butY.addEventListener('click',function(e)
            {
                if(input.value==rand)
                {
                   window.open(link); 
                }
                e.target.parentElement.parentElement.remove();
            })
            div3.appendChild(butY);

            let butN=document.createElement('button');
            butN.innerHTML="Ne";
            butN.addEventListener('click',function(e)
            {
                e.target.parentElement.parentElement.remove();
            })
            div3.appendChild(butN);

            div.append(div2,div21,div3);
            document.querySelector('.prazan').appendChild(div);
    }))

    // //filter
    
    // document.querySelector('#filter').addEventListener('change',function(e)
    // {
    //     let word=document.querySelector('#filter').value.toLowerCase();
    //     let trNiz=[...document.querySelectorAll('tr')];
    //     for(tr of trNiz)
    //     {
    //         let array=[...tr.childNodes];
    //         let c1=false; let c2=false;
    //         array.map(function(c)
    //         {
    //             if(c.tagName=='TD')
    //             {
    //                 c1=true;
    //             }

    //             if(typeof(c.innerHTML)==='string' && c.innerHTML.toLowerCase().includes(word))
    //             {
    //                 c2=true;
    //             }
    //         })
            
    //         if(c1 && c2)
    //         {
    //             tr.classList.remove('disapear');
    //         }
    //         else if(c1 && !c2)
    //         {
    //             tr.classList.add('disapear');
    //         }
    //     }
    // })

</script>
@endsection