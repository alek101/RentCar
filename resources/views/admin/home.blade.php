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
        div.append('Da li ste sigurni?   ');

        let butY=document.createElement('button');
        butY.innerHTML="Da";
        butY.addEventListener('click',function(e)
        {
            window.open(link);
            e.target.parentElement.remove();
        })
        div.appendChild(butY);

        let butN=document.createElement('button');
        butN.innerHTML="Ne";
        butN.addEventListener('click',function(e)
        {
            e.target.parentElement.remove();
        })
        div.appendChild(butN);

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