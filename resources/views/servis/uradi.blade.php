@extends('mainPage')
@section('Page')

<h3>Za produzenje registracije, izaberite opciju.</h3>

<form method="POST" action="/servis/endServis" class='formZakazivanje'>
    <div class="flexColumn">
        <div>@csrf</div>
        
        <div class="flexRow">
            <label for="id">Broj Sasije <input type="text" name='id' value="<?=$id?>" id="id" required></label>
        </div>
        <div class="flexRow">
            <label for="tip">
                Tip <br> <select name="tip" id="tip">
                            <option value="mali">Mali</option>
                            <option value="veliki">Veliki</option>
                            <option value="registracija">Registracija</option>
                            {{-- <option value="cancel">Otkazi</option> --}}
                    </select>
            </label>
        </div>
        <div class="flexRow">
            <label for="datum">
                Datum Servisa <input type="date" name="datum" id="datum" value='<?php echo date("Y-m-d")?>'>
            </label>
            <label for="registracija">
                Novo Vazanje Registracije <input type="date" name="registracija" id="registracija" value=''>
            </label>
        </div>
        <div class="flexRow">
            <label for="um">Ulje motora<input type="checkbox" id="um" class='inputCheckBox'></label>
            <label for="fut">Filter ulja motora<input type="checkbox" id="fut" class='inputCheckBox'></label>
            <label for="fg">Filter goriva<input type="checkbox" id="fg" class='inputCheckBox'></label>
            <label for="fv">Filter vazduha<input type="checkbox" id="fv" class='inputCheckBox'></label>
            <label for="fk">Filter kabine<input type="checkbox" id="fk" class='inputCheckBox'></label>
        </div>
        
        <div><label for="opis">  Opis <br> <textarea name="opis" id="opis" cols="30" rows="10"></textarea></label></div>
        <div><input type="submit" value="Posalji" id="dugme"></div>
        
    </div>
    
</form>

<script>
    function upisi(text)
    {
        document.querySelector('#opis').innerHTML+=text;
    }

    document.querySelector('#um').addEventListener('change',function()
    {
            upisi('Promenjeno je ulje motora. ');
    })

    document.querySelector('#fut').addEventListener('change',function()
    {
            upisi('Promenjen je fillter ulja motora. ');
    })

    document.querySelector('#fg').addEventListener('change',function()
    {
            upisi('Promenjen filter goriva. ');
    })

    document.querySelector('#fv').addEventListener('change',function()
    {
            upisi('Promenjen je filter vazduha. ');
    })

    document.querySelector('#fk').addEventListener('change',function()
    {
            upisi('Promenjen je filter kabine. ');
    })


</script>

@endsection