//filter tabela
        
try {
    if(document.querySelector('#filter')!=null)
    {
        let storedWord=sessionStorage.getItem('filterTabela');
        if(storedWord!=null)
        {
            document.querySelector('#filter').value=storedWord;
            searchTable();
        }
        document.querySelector('#filter').addEventListener('change',function(e)
        {
            searchTable();
        })
    }
    
} catch (error) {
    console.log("filter tabela ili session storage "+error);
}

function searchTable()
{
    let word=document.querySelector('#filter').value.toLowerCase();
    sessionStorage.setItem('filterTabela',word);
    let trNiz=[...document.querySelectorAll('tr')];
    for(tr of trNiz)
    {
        let array=[...tr.childNodes];
        let c1=false; let c2=false;
        array.map(function(c)
        {
            if(c.tagName=='TD')
            {
                c1=true;
            }

            if(typeof(c.innerHTML)==='string' && c.innerHTML.toLowerCase().includes(word))
            {
                c2=true;
            }
        })
        
        if(c1 && c2)
        {
            tr.classList.remove('disapear');
        }
        else if(c1 && !c2)
        {
            tr.classList.add('disapear');
        }
    }
}

//poziv za brisanje iz baze
//neophodno je ubaciti div sa klasom .prazan

try 
{
    if(document.querySelectorAll('.obrisi')!=null && document.querySelector('.prazan')!=null)
    {
        obrisiSaKarticom(); 
    }
} 
catch (error) 
{
    console.log('brisanje sa karticom '+error);
}


function obrisiSaKarticom()
{
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
            div2.append('Upišite sledeci broj: ',rand);

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
                   window.open(link,'_self'); 
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
}

//poziv za produzenje rezervacije

try 
{
    if(document.querySelectorAll('.produzi')!=null)
    {
        produziRezervaciju();
    }
} 
catch (error) 
{
    console.log('produzenje rezervacije '+error);
}

function produziRezervaciju()
{
    let butoniProduzi=[...document.querySelectorAll('.produzi')];
        butoniProduzi.map(b=>b.addEventListener('click', function()
        {
            window.open(b.getAttribute('data-link'),'_self');
    }));
}

//poziv za zakazivanje servisa

try 
{
    if(document.querySelectorAll('.zakaziServis')!=null)
    {
        let dugmici=[...document.querySelectorAll('.zakaziServis')];
        dugmici.map(c=>c.addEventListener('click',function(e)
        {
            let sasija=e.target.getAttribute("data-sasija");
            window.open("/kriticni/initiateServis/"+sasija,'_self');
        }))
    }
} 
catch (error) 
{
    console.log('zakazi servis '+error);
}

//poziv za otvaranje linka

try 
{
    if(document.querySelectorAll('.linkDugme')!=null)
    {
        let dugmici=[...document.querySelectorAll('.linkDugme')];
        dugmici.map(c=>c.addEventListener('click',function(e)
        {
            let link=e.target.getAttribute("data-link");
            console.log(link);
            window.open(link,'_self');
        }))
    }
} 
catch (error) 
{
    console.log('zakazi servis '+error);
}




//vadi ime slike iz session storaga i upisuje u polje sa imenom slike

// try 
// {
//     if(document.querySelector('#slikaIme')!=null)
//     {
//         let nameImage=sessionStorage.getItem('nameImage');
//         if(nameImage!=null)
//         {
//             document.querySelector('#slikaIme').value=nameImage;
//         }
//     }
// } catch (error) 
// {
//     console.log('uzimanje imena slika is sess. stor. '+error);
// }

//da izvadi ime slike iz fajla i upise ga na mesto i u session storage

// try 
// {
//     if(document.querySelector('#slika')!=null && document.querySelector('#slikaIme')!=null)
//     {
//         document.querySelector('#slika').addEventListener('change',function(e)
//         {
//             let nameImage=document.querySelector('#slika').value.slice(12);
//             document.querySelector('#slikaIme').value=nameImage;
//             sessionStorage.setItem('nameImage',nameImage);
//         })
//     }
// } catch (error) 
// {
//     console.log('upis ime slike '+error);
// }
    