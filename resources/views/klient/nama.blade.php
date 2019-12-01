@extends('index')
@section('PageF')
<section class="dodaci">
    <h1 class="white">Najbolja RentCar Agencija</h1>
    <div class="containerNama">
        
        <div class="slikaNama">
            <img src="{!! asset('/images\wind-farm-1747331_640.jpg') !!}" alt="">
        </div>
        <div class="textNama">

            Mi smo kao agencija osnovani 2019. godine od strane našeg velikog osnivača, gospodina Vetrenjače. Mi smo najbolja agencija jer ne postavljamo nerazumne
             uslove kao što to rade druge agencije. Ne diskriminišemo mlade vozače, naše mušterije su uvek osigurane, ne tražimo učešće ili registraciju na našem
             sajtu da biste rezervisali vozilo. Može se reći da smo mi agencija iz bajke, ili da mi u stvari ne postojimo. 
            
            <h3 class='margin_top_20'>Kontakt</h3>

            <ul>
                <li>Adresa: Nepoznata BB</li>
                <li>Telefon: 011/xxx-xx-xx</li>
                <li>Radno vreme: 6h-22h</li>
            </ul>

            <div class="margin_top_40">
                <span><a href="http://www.facebook.com"><img class="img_drust" src="/images/facebook_logos_PNG19748.png" alt="facebook"></a></span>
                <span><a href="http://www.instragram.com"><img class="img_drust" src="/images/instagram_PNG11.png" alt="instagram"></a></span>
                <span><a href="http://www.twitter.com"><img class="img_drust" src="/images/twitter_PNG14.png" alt="twitter"></a></span>
            </div>
            
        </div>
    </div>
</section>
@endsection
