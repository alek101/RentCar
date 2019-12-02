@extends('mainPage')
@section('Page')

<h3>Za produženje registracije, izaberite tip radova: Registracija.</h3>

<form method="POST" action="/servis/endServis" class='formZakazivanje'>
    <div class="flexColumn">
        <div>@csrf</div>
        
        <div class="flexRow">
            <label for="id">Broj Šasije <input type="text" name='id' value="<?=$id?>" id="id" readonly required></label>
        </div>
        <div class="flexRow">
            <label for="tip">
                Tip radova: <br> <select name="tip" id="tip">
                            <option value="mali">Mali Servis</option>
                            <option value="veliki">Veliki Servis</option>
                            <option value="registracija">Registracija</option>
                    </select>
            </label>
        </div>
        <div class="flexRow ser">
            <label for="datum" id="labelStartB">
                Datum Servisa <input type="date" name="datum" id="datum" value='<?php echo date("Y-m-d")?>'>
            </label>
            <label for="Datum_vazenja_registracije_Input" id="labelStart2B"  class="disapear"> 
                    Datum Servisa<input type="text" id="Datum_vazenja_registracije_InputB">
            </label>
        </div> 

        <div class="flexRow reg cardDisapear">       
            <label for="registracija" id="labelStart" class="disapear">
                Novo Važenje Registracije <input type="date" name="registracija" id="registracija" value=''>
            </label>
            <label for="Datum_vazenja_registracije_Input" id="labelStart2" > 
                Novo Važenje Registracije <input type="text" id="Datum_vazenja_registracije_Input">
            </label>
        </div>
        <div class="flexRow ser2">
            <label for="um">Ulje motora<input type="checkbox" id="um" class='inputCheckBox'></label>
            <label for="fut">Filter ulja motora<input type="checkbox" id="fut" class='inputCheckBox'></label>
            <label for="fg">Filter goriva<input type="checkbox" id="fg" class='inputCheckBox'></label>
            <label for="fv">Filter vazduha<input type="checkbox" id="fv" class='inputCheckBox'></label>
            <label for="fk">Filter kabine<input type="checkbox" id="fk" class='inputCheckBox'></label>
        </div>
        
        
        <div><label for="opis" class="labelOpis">  Opis radova: <br> <textarea name="opis" id="opis" cols="30" rows="10" placeholder='Nema Opisa'></textarea></label></div>
        
        
        <div class="flexRow">
            <div><input type="submit" value="Pošalji" id="dugme"></div>
        </div>
        
        
    </div>
    
</form>

<script src="{{ asset('js/biblioteka.js') }}"></script>
<script src="{{ asset('js/upisiServis.js') }}"></script>


@endsection