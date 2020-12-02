const c = (el)=>document.querySelector(el);
const cs = (el)=>document.querySelectorAll(el);
var blocoNotas = document.getElementById('blocoNotas').checked;


function ativarBloco() {
    var blocoNotas = document.getElementById('blocoNotas').checked;

    if(blocoNotas == true) {
        c('.largura').style.width = '70%'; 
        c('.blocoNotasCorpo').style.display = 'block'; 
    } else {
        c('.blocoNotasCorpo').style.display = 'none';   
        c('.largura').style.width = '100%';  
    };

    
}

if(blocoNotas == true) {
    c('.largura').style.width = '70%'; 
    c('.blocoNotasCorpo').style.display = 'block'; 
}