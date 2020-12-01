const c = (el)=>document.querySelector(el);
const cs = (el)=>document.querySelectorAll(el);


function ativarBloco() {
    var blocoNotas = document.getElementById('blocoNotas').checked;

    if(blocoNotas == true) {
        c('.largura').style.width = '70%'; 
        c('.copiarColar').style.display = 'block'; 
    } else {
        c('.copiarColar').style.display = 'none';   
        c('.largura').style.width = '100%';  
    };

    
}
