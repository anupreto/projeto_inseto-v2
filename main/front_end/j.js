(() => {
    "use strict";

    const root = document.documentElement;
    const storageKey = "wiki-invertebrados-theme";

    let temaAtual = "dark";

    try {
        const temaSalvo = localStorage.getItem(storageKey);

        if (temaSalvo === "light" || temaSalvo === "dark") {
            temaAtual = temaSalvo;
        }
    } catch (erro) {
        // Continua funcionando sem localStorage.
    }

    root.dataset.theme = temaAtual;
    root.style.colorScheme = temaAtual;

    const estilos = document.createElement("style");

    estilos.textContent = `
        body,
        .wiki-header,
        .artigo-bloco,
        .sidebar-box,
        .card-categoria,
        .card-confortavel,
        .foto-inseto,
        .bloco-curiosidade,
        .btn-voltar {
            transition:
                background-color 0.25s ease,
                color 0.25s ease,
                border-color 0.25s ease;
        }

        /* TEMA CLARO */

        :root[data-theme="light"] body {
            background-color: #f6f8fa !important;
            color: #24292f !important;
        }

        :root[data-theme="light"] .wiki-header,
        :root[data-theme="light"] .artigo-bloco,
        :root[data-theme="light"] .sidebar-box,
        :root[data-theme="light"] .card-confortavel,
        :root[data-theme="light"] main:not(.wiki-content) {
            background-color: #ffffff !important;
            border-color: #d0d7de !important;
            color: #24292f !important;
        }

        :root[data-theme="light"] .card-categoria,
        :root[data-theme="light"] .foto-inseto,
        :root[data-theme="light"] .bloco-curiosidade,
        :root[data-theme="light"] .btn-voltar {
            background-color: #f6f8fa !important;
            border-color: #d0d7de !important;
            color: #24292f !important;
        }

        :root[data-theme="light"] p,
        :root[data-theme="light"] .logo-area p,
        :root[data-theme="light"] .topo-nav a,
        :root[data-theme="light"] .card-categoria p,
        :root[data-theme="light"] .sidebar-box p,
        :root[data-theme="light"] .artigo-bloco p,
        :root[data-theme="light"] .dado-item,
        :root[data-theme="light"] .bloco-curiosidade p,
        :root[data-theme="light"] .foto-inseto {
            color: #57606a !important;
        }

        :root[data-theme="light"] h1,
        :root[data-theme="light"] .logo-area h1,
        :root[data-theme="light"] .artigo-bloco h2,
        :root[data-theme="light"] .bloco-curiosidade h3,
        :root[data-theme="light"] .card-titulo h1 {
            color: #0969da !important;
        }

        :root[data-theme="light"] .sidebar-box h3,
        :root[data-theme="light"] .card-categoria h3,
        :root[data-theme="light"] .dado-item strong {
            color: #24292f !important;
        }

        :root[data-theme="light"] a {
            color: #0969da !important;
        }

        :root[data-theme="light"] .artigo-bloco h2,
        :root[data-theme="light"] .sidebar-box h3,
        :root[data-theme="light"] .card-titulo h1 {
            border-color: #d8dee4 !important;
        }

        :root[data-theme="light"] hr {
            background-color: #d8dee4 !important;
        }

        /* BOTÃO DE TEMA */

        #theme-toggle {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 9999;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 12px 16px;
            border: 1px solid #30363d;
            border-radius: 999px;

            background-color: #161b22;
            color: #c9d1d9;

            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: 600;

            cursor: pointer;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);

            transition:
                transform 0.2s ease,
                background-color 0.25s ease,
                color 0.25s ease;
        }

        #theme-toggle:hover {
            transform: translateY(-2px);
            border-color: #58a6ff;
        }

        #theme-toggle:focus-visible {
            outline: 3px solid #58a6ff;
            outline-offset: 3px;
        }

        :root[data-theme="light"] #theme-toggle {
            background-color: #ffffff;
            color: #24292f;
            border-color: #d0d7de;
        }

        @media (max-width: 520px) {
            #theme-toggle {
                right: 12px;
                bottom: 12px;
                padding: 11px 13px;
                font-size: 13px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
        }
    `;

    document.head.appendChild(estilos);

    const botao = document.createElement("button");
    botao.id = "theme-toggle";
    botao.type = "button";

    const icone = document.createElement("span");
    icone.setAttribute("aria-hidden", "true");

    const texto = document.createElement("span");

    botao.appendChild(icone);
    botao.appendChild(texto);

    function aplicarTema(tema, salvar = true) {
        root.dataset.theme = tema;
        root.style.colorScheme = tema;

        const temaClaro = tema === "light";

        icone.textContent = temaClaro ? "🌙" : "☀️";
        texto.textContent = temaClaro ? "Tema escuro" : "Tema claro";

        botao.setAttribute(
            "aria-label",
            temaClaro
                ? "Alternar para tema escuro"
                : "Alternar para tema claro"
        );

        botao.setAttribute("aria-pressed", String(temaClaro));

        if (salvar) {
            try {
                localStorage.setItem(storageKey, tema);
            } catch (erro) {
                // A troca de tema continua funcionando.
            }
        }
    }

    botao.addEventListener("click", () => {
        const novoTema =
            root.dataset.theme === "light" ? "dark" : "light";

        aplicarTema(novoTema);
    });

    function iniciar() {
        if (!document.body.contains(botao)) {
            document.body.appendChild(botao);
        }

        aplicarTema(root.dataset.theme || temaAtual, false);
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", iniciar, {
            once: true
        });
    } else {
        iniciar();
    }
})();// fazer interface
