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
        <th>Change Role</th>
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
                    ."<td><button class='linkDugme' data-link='/admin/roleChange/".$user->id."'>Change Role</button></td>"

                    ."<td><button class='obrisi' data-link='/admin/delete/$user->id'>Remove</button></td>"
                    
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

@endsection