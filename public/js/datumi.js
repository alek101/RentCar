//selectori

//vec deklarisani
// let dateStartInput=document.querySelector('#start');
// let dateEndInput=document.querySelector('#end');
// let dateStartInput2=document.querySelector('#start2');
// let dateEndInput2=document.querySelector('#end2');

let dateStartLabel=document.querySelector('#labelStart');
let dateEndLabel=document.querySelector('#labelEnd');
let dateStartLabel2=document.querySelector('#labelStart2');
let dateEndLabel2=document.querySelector('#labelEnd2');

function changeVisibilityStart()
{
    dateStartLabel.classList.toggle('disapear');
    dateStartLabel2.classList.toggle('disapear');
}

function changeVisibilityEnd()
{
    dateEndLabel.classList.toggle('disapear');
    dateEndLabel2.classList.toggle('disapear');
}

//dogadjaji
dateStartInput.addEventListener('change',function()
{
    changeVisibilityStart();
    dateStartInput2.value=pf.dateToSerbianFormat(dateStartInput.value);
})

dateEndInput.addEventListener('change',function()
{
    changeVisibilityEnd();
    dateEndInput2.value=pf.dateToSerbianFormat(dateEndInput.value);
})

dateStartInput2.addEventListener('click',function()
{
    changeVisibilityStart();
    dateStartInput.value="";
    dateStartInput.focus();

})

dateEndInput2.addEventListener('click',function()
{
    changeVisibilityEnd();
    dateEndInput.value="";
    dateEndInput.focus();
})



