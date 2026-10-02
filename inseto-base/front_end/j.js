// ========================================
// PROJETO INSETOS
// JavaScript - Front-end
// ========================================


// Quando a página carregar
document.addEventListener("DOMContentLoaded", function () {

    carregarInsetos();

    configurarMenu();

});


// ========================================
// VARIÁVEIS
// ========================================

let insetos = [];


// Elementos do HTML
const conteudo = document.querySelector(".wiki-content");
const sidebar = document.querySelector(".wiki-sidebar");
const menu = document.querySelector(".topo-nav");

// ========================================
// PESQUISA
// ========================================

function pesquisarInsetos(texto) {

    texto = texto.toLowerCase();

    const resultados = insetos.filter(function (inseto) {

        return (
            inseto.nome
                .toLowerCase()
                .includes(texto)

            ||

            inseto.categoria
                .toLowerCase()
                .includes(texto)

            ||

            inseto.descricao
                .toLowerCase()
                .includes(texto)
        );

    });

    mostrarPesquisa(resultados, texto);

}


// ========================================
// MOSTRAR PESQUISA
// ========================================

function mostrarPesquisa(resultados, texto) {

    const antigo =
        document.querySelector(".resultado-pesquisa");

    if (antigo) {

        antigo.remove();

    }

    const bloco = document.createElement("section");

    bloco.classList.add("artigo-bloco");

    bloco.classList.add("resultado-pesquisa");

    const titulo = document.createElement("h2");

    titulo.textContent = "Pesquisa";

    const textoPesquisa = document.createElement("p");

    textoPesquisa.textContent =
        'Resultados para: "' + texto + '"';

    const grid = document.createElement("div");

    grid.classList.add("grid-categorias");

    if (resultados.length === 0) {

        const card = document.createElement("div");

        card.classList.add("card-categoria");

        const tituloCard = document.createElement("h3");

        tituloCard.textContent =
            "Nenhum resultado";

        const textoCard = document.createElement("p");

        textoCard.textContent =
            "Nenhum inseto foi encontrado.";

        card.appendChild(tituloCard);

        card.appendChild(textoCard);

        grid.appendChild(card);

    }

    else {

        resultados.forEach(function (inseto) {

            grid.appendChild(
                criarCard(inseto)
            );

        });

    }

    bloco.appendChild(titulo);

    bloco.appendChild(textoPesquisa);

    bloco.appendChild(grid);

    conteudo.appendChild(bloco);

}


// ========================================
// DISPONIBILIZAR PESQUISA
// ========================================

window.pesquisarInsetos = pesquisarInsetos;


// ========================================
// TEMA CLARO / ESCURO
// ========================================

function aplicarTema(tema) {

    document.documentElement.setAttribute("data-theme", tema);

    // Salva o tema escolhido pelo usuário
    localStorage.setItem("tema", tema);

    const botaoTema = document.getElementById("alternar-tema");

    if (botaoTema) {

        if (tema === "dark") {

            botaoTema.textContent = "☀️ Modo claro";
            botaoTema.setAttribute(
                "aria-label",
                "Ativar modo claro"
            );

        } else {

            botaoTema.textContent = "🌙 Modo escuro";
            botaoTema.setAttribute(
                "aria-label",
                "Ativar modo escuro"
            );
        }
    }
}


// ========================================
// CONFIGURAR TEMA
// ========================================

function configurarTema() {

    // Tenta recuperar o tema salvo
    let temaSalvo = localStorage.getItem("tema");

    // Se não existir, começa no modo escuro
    if (temaSalvo !== "light" && temaSalvo !== "dark") {
        temaSalvo = "dark";
    }


    // ========================================
    // CRIAR BOTÃO
    // ========================================

    let botaoTema = document.getElementById("alternar-tema");

    if (!botaoTema) {

        botaoTema = document.createElement("button");

        botaoTema.id = "alternar-tema";

        botaoTema.type = "button";

        const navegacao = document.querySelector(".topo-nav");

        if (navegacao) {

            navegacao.appendChild(botaoTema);

        } else {

            document.body.appendChild(botaoTema);
        }
    }


    // Aplica o tema salvo
    aplicarTema(temaSalvo);


    // ========================================
    // CLIQUE DO BOTÃO
    // ========================================

    botaoTema.addEventListener("click", function () {

        const temaAtual =
            document.documentElement.getAttribute("data-theme");

        let novoTema;

        if (temaAtual === "dark") {

            novoTema = "light";

        } else {

            novoTema = "dark";
        }

        aplicarTema(novoTema);
    });
}


// ========================================
// INICIAR TEMA
// ========================================

document.addEventListener("DOMContentLoaded", function () {

    configurarTema();

});
