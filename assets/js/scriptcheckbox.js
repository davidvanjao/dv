const c = (el)=>document.querySelector(el);
const cs = (el)=>document.querySelectorAll(el);


blocoNotas = "";

function blocoNotas() {
    var blocoNotas = document.getElementById('blocoNotas').checked;

    if(blocoNotas == true) {
        c('.copiarColar').style.display = 'block'; 
    } else {
        c('.copiarColar').style.display = 'none';    
    };

    
}