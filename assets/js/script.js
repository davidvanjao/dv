let atualizar;
var min;
var seg;

min = 20;		
seg = 1;


function iniciarAtualizar() {
    console.log("Ola mundo!"); // ativa a atualizacao da pagina.
    location.reload();
}

function pararAtualizar() {
    clearInterval(atualizar); // para a atualizacao da pagina.
    clearInterval(atualizaRelogio); // para a atualizacao da pagina.
}
        
function relogio(){			
    if((min > 0) || (seg > 0)){				
        if(seg == 0){					
            seg = 59;					
            min = min - 1	
        }				
        else{					
            seg = seg - 1;				
        }				
        if(min.toString().length == 1){					
            min = "0" + min;				
        }				
        if(seg.toString().length == 1){					
            seg = "0" + seg;				
        }				
        document.getElementById('spanRelogio').innerHTML = min + ":" + seg;				
        atualizaRelogio = setTimeout('relogio()', 1000);			
    }			
    else{				
        document.getElementById('spanRelogio').innerHTML = "00:00";			
    }		
}	


function funcao1() {

    var confirmar = confirm("Você realmente deseja liberar?");

    if(confirmar == true) {

        return true;

    } else {

        return false;
    }
}

atualizar = setInterval(iniciarAtualizar, 1200000);
relogio();

