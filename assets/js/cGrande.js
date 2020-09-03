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


function AtualizarCartaz() {
    descricao = c('#painel-Descricao').value;
    c('.corpoCartaz-Descricao textarea').innerHTML = descricao;

    marca = c('#painel-Marca').value;
    c('.corpoCartaz-Titulo').innerHTML = marca;

    real = c('#painel-Real').value;
    c('.corpoCartaz-Preco .real').innerHTML = real;

    moeda = c('#painel-Moeda').value;
    c('.corpoCartaz-Preco .moeda').innerHTML = moeda;

    seMedida = c('#painel-Medida');
    opMedida = seMedida.options[seMedida.selectedIndex];
    c('.corpoCartaz-Preco .medida').innerHTML = opMedida.text;

    seMotivo = c('#painel-Motivo');
    opMotivo = seMotivo.options[seMotivo.selectedIndex];
    c('.corpoCartaz-Motivo h1').innerHTML = opMotivo.text;

}

setInterval(AtualizarCartaz, 100);