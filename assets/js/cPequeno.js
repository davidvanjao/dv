const c = (el)=>document.querySelector(el);
const cs = (el)=>document.querySelectorAll(el);


descricao = "";
marca = "";
real = "";
moeda = "";
seMedida = "";
opMedida = "";
seMotivo = "";
opMotivo = "";

descricaoNovo = "";
marcaNovo = "";
realNovo = "";
moedaNovo = "";
seMedidaNovo = "";
opMedidaNovo = "";
seMotivoNovo = "";
opMotivoNovo = "";


function AtualizarCartaz() {
    descricao = c('#painel-Descricao').value;
    c('.corpoCartaz-Descricao textarea').innerHTML = descricao;
    c('.CartazImpressao-2 .corpoCartaz-Descricao textarea').innerHTML = descricao;

    marca = c('#painel-Marca').value;
    c('.corpoCartaz-Titulo').innerHTML = marca;
    c('.CartazImpressao-2 .corpoCartaz-Titulo').innerHTML = marca;


    real = c('#painel-Real').value;
    c('.corpoCartaz-Preco .real').innerHTML = real;
    c('.CartazImpressao-2 .corpoCartaz-Preco .real').innerHTML = real;


    moeda = c('#painel-Moeda').value;
    c('.corpoCartaz-Preco .moeda').innerHTML = moeda;
    c('.CartazImpressao-2 .corpoCartaz-Preco .moeda').innerHTML = moeda;


    seMedida = c('#painel-Medida');
    opMedida = seMedida.options[seMedida.selectedIndex];
    c('.corpoCartaz-Preco .medida').innerHTML = opMedida.text;
    c('.CartazImpressao-2 .corpoCartaz-Preco .medida').innerHTML = opMedida.text;

    seMotivo = c('#painel-Motivo');
    opMotivo = seMotivo.options[seMotivo.selectedIndex];
    c('.corpoCartaz-Motivo h1').innerHTML = opMotivo.text;
    c('.CartazImpressao-2 .corpoCartaz-Motivo h1').innerHTML = opMotivo.text;


   /*=================================PAINEL NOVO========================================================*/


   descricaoNovo = c('.painel-novo #painel-Descricao').value;
   c('.CartazImpressao-3 .corpoCartaz-Descricao textarea').innerHTML = descricaoNovo;

   marcaNovo = c('.painel-novo #painel-Marca').value;
   c('.CartazImpressao-3 .corpoCartaz-Titulo').innerHTML = marcaNovo;


   realNovo = c('.painel-novo #painel-Real').value;
   c('.CartazImpressao-3 .corpoCartaz-Preco .real').innerHTML = realNovo;


   moedaNovo = c('.painel-novo #painel-Moeda').value;
   c('.CartazImpressao-3 .corpoCartaz-Preco .moeda').innerHTML = moedaNovo;


   seMedidaNovo = c('.painel-novo #painel-Medida');
   opMedidaNovo = seMedidaNovo.options[seMedidaNovo.selectedIndex];
   c('.CartazImpressao-3 .corpoCartaz-Preco .medida').innerHTML = opMedidaNovo.text;

   seMotivoNovo = c('.painel-novo #painel-Motivo');
   opMotivoNovo = seMotivoNovo.options[seMotivoNovo.selectedIndex];
   c('.CartazImpressao-3 .corpoCartaz-Motivo h1').innerHTML = opMotivoNovo.text;


}

/*=================================CHECAGEM DE OPÇÃO========================================================*/

function checarNumeroCartaz() {
    var cartazUnico = document.getElementById('cartaz-Unico').checked;
    var cartazDuplicar = document.getElementById('cartaz-Duplicar').checked;
    var cartazNovo = document.getElementById('cartaz-Novo').checked;


    if(cartazDuplicar == true) {
        c('.CartazImpressao-2').style.display = 'flex'; 
    } else {
        c('.CartazImpressao-2').style.display = 'none';    
    };

    if(cartazNovo == true) {
        c('.CartazImpressao-3').style.display = 'flex'; 
        c('.painel-novo').style.display = 'flex'; 
    } else {
        c('.CartazImpressao-3').style.display = 'none'; 
        c('.painel-novo').style.display = 'none';    
    };


    
}







setInterval(AtualizarCartaz, 100);
