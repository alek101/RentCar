@extends('mainPage')
@section('Page')

<h3>Za produzenje registracije, izaberite opciju.</h3>

<form method="POST" action="/servis/finish" class='formZakazivanje'>
    <div class="flexColumn">
        <div>@csrf</div>
        
        <div class="flexRow">
            <label for="id">Broj Sasije <input type="text" name='id' value="<?=$id?>" id="id"></label>
            <label for="tip">
                Tip <select name="tip" id="tip">
                            <option value="mali">Mali</option>
                            <option value="veliki">Veliki</option>
                            <option value="registracija">Registracija</option>
                            <option value="cancel">Otkazi</option>
                        </select>
            </label>
            <label for="datum">
                Datum Servisa <input type="date" name="datum" id="datum" value='<?php echo date("Y-m-d")?>'>
            </label>
            <label for="registracija">
                Novo Vazanje Registracije <input type="date" name="registracija" id="registracija" value=''>
            </label>
        </div>
        
        <div><label for="opis">  Opis <br> <textarea name="opis" id="opis" cols="30" rows="10"></textarea></label></div>
        <div><input type="submit" value="Posalji" id="dugme"></div>
        
       
        
        
         
    </div>
    

</form>

@endsection