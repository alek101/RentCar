@extends('mainPage')
@section('Page')

{{-- @php
    var_dump($users);
@endphp --}}

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
    
                    
                    ."<td> <a href='/admin/delete/".$user->id."'>Delete</td>"
                    
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