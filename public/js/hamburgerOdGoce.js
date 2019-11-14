//za hamburger
var secbr = document.querySelector('.mg-best-rooms') ||  document.querySelector('.text-center') ;
var navOnScroll = document.querySelector('#navOnScroll');
var navOnScrollDiv = document.querySelector('#navOnScrollDiv');
var st, pt;
document.addEventListener('scroll', function(){
    let st = parseInt(secbr.offsetTop);
    let pt = parseInt(document.documentElement.scrollTop || document.body.scrollTop);
    if(pt>=st){
        navOnScroll.classList.remove('navbar-expand-lg');
        if(!navOnScrollDiv.classList.contains('sticky-top')) navOnScrollDiv.classList.add('sticky-top');
    }else{
        if(!navOnScrollDiv.classList.contains('navbar-expand-lg')) navOnScroll.classList.add('navbar-expand-lg');
        navOnScrollDiv.classList.remove('sticky-top');
    }
})