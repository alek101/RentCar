@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($users);
@endphp --}}

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
</script>
@endsection