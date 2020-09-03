const c = (el)=>document.querySelector(el);
const cs = (el)=>document.querySelectorAll(el);

var painelWidget = c('.painel-menu-menu');
var modalFechar = c('.painel-menu-modal');



painelWidget.querySelector('a').addEventListener('click', (e)=>{
    e.preventDefault();

    c('.painel-menu-modal').style.display = 'flex';
    c('.painel-menu-menu').style.display = 'none';

    console.log("Abriu Opções de Cartaz");
});

modalFechar.querySelector('.painel-menu-fechar').addEventListener('click', (e)=>{
    e.preventDefault();

    c('.painel-menu-modal').style.display = 'none';
    c('.painel-menu-menu').style.display = 'flex';

    console.log("Fechou Opções de Cartaz");
});