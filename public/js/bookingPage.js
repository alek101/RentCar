//ovo je za kartice
function showForma()
{
    document.querySelector('.divForma').classList.remove('disapear');
    document.querySelector('.divKartice').classList.add('disapear');
}

function showKartice()
{
    document.querySelector('.divForma').classList.add('disapear');
    document.querySelector('.divKartice').classList.remove('disapear');
}

document.querySelector('#aForma').addEventListener('click',function(e)
    {
        e.preventDefault();
        showForma();
    })

document.querySelector('#aKartica').addEventListener('click',function(e)
{
    e.preventDefault();
    showKartice();
})

//filter po ceni 

document.querySelector('#filterKartica').addEventListener('click',function(e)
{
    e.preventDefault();
    document.querySelector('.meniFilter').classList.toggle('cardDisapear');
});

function filtirajPoCeni(min,max)
{
    console.log('radi funkcija');
    min=document.querySelector('#minCena').value || 0;
    max=document.querySelector('#maxCena').value || Infinity;

    let pCena=[...document.querySelectorAll('.cenaOpisCard')];

    pCena.map(function(elCena)
    {
        let cenaIznos=parseFloat(elCena.getAttribute('data-cena'));
        if(cenaIznos>=min && cenaIznos<=max)
        {
            elCena.parentElement.parentElement.classList.remove('cardDisapear');
        }
        else
        {
            elCena.parentElement.parentElement.classList.add('cardDisapear');
        }
    });
}

document.querySelector('#minCena').addEventListener('change',function()
{
    filtirajPoCeni();
});

document.querySelector('#maxCena').addEventListener('change',function()
{
    filtirajPoCeni();
});