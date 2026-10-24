(() => {
    "use strict";

    const STORAGE_KEY = "wiki-invertebrados-theme";
    const root = document.documentElement;

    let theme = "dark";

    try {
        const savedTheme = localStorage.getItem(STORAGE_KEY);

        if (savedTheme === "light" || savedTheme === "dark") {
            theme = savedTheme;
        }
    } catch (error) {
        // Continua funcionando sem localStorage.
    }

    root.dataset.theme = theme;
    root.style.colorScheme = theme;

    const style = document.createElement("style");

    style.textContent = `
        body,
        .wiki-header,
        .artigo-bloco,
        .sidebar-box,
        .card-categoria,
        .card-confortavel,
        .foto-inseto,
        .bloco-curiosidade,
        .btn-voltar,
        main {
            transition:
                background-color .2s ease,
                color .2s ease,
                border-color .2s ease;
        }

        /* TEMA CLARO */

        :root[data-theme="light"] body {
            background: #f6f8fa !important;
            color: #24292f !important;
        }

        :root[data-theme="light"] .wiki-header,
        :root[data-theme="light"] .artigo-bloco,
        :root[data-theme="light"] .sidebar-box,
        :root[data-theme="light"] .card-confortavel,
        :root[data-theme="light"] main {
            background: #ffffff !important;
            color: #24292f !important;
            border-color: #d0d7de !important;
        }

        :root[data-theme="light"] .card-categoria,
        :root[data-theme="light"] .foto-inseto,
        :root[data-theme="light"] .bloco-curiosidade,
        :root[data-theme="light"] .btn-voltar {
            background: #f6f8fa !important;
            color: #24292f !important;
            border-color: #d0d7de !important;
        }

        :root[data-theme="light"] p,
        :root[data-theme="light"] li,
        :root[data-theme="light"] .logo-area p,
        :root[data-theme="light"] .card-categoria p,
        :root[data-theme="light"] .sidebar-box p,
        :root[data-theme="light"] .artigo-bloco p,
        :root[data-theme="light"] .dado-item,
        :root[data-theme="light"] .bloco-curiosidade p {
            color: #57606a !important;
        }

        :root[data-theme="light"] h1,
        :root[data-theme="light"] .logo-area h1,
        :root[data-theme="light"] .artigo-bloco h2,
        :root[data-theme="light"] .bloco-curiosidade h3,
        :root[data-theme="light"] .card-titulo h1 {
            color: #0969da !important;
        }

        :root[data-theme="light"] h2,
        :root[data-theme="light"] h3,
        :root[data-theme="light"] h4,
        :root[data-theme="light"] strong,
        :root[data-theme="light"] .dado-item strong {
            color: #24292f !important;
        }

        :root[data-theme="light"] a {
            color: #0969da !important;
        }

        :root[data-theme="light"] hr {
            background-color: #d8dee4 !important;
            border-color: #d8dee4 !important;
        }

        :root[data-theme="light"] input,
        :root[data-theme="light"] select,
        :root[data-theme="light"] textarea {
            background: #ffffff !important;
            color: #24292f !important;
            border-color: #d0d7de !important;
        }

        /* BOTÃO DE TEMA */

        #theme-toggle {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 99999;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 12px 16px;
            border: 1px solid #30363d;
            border-radius: 999px;

            background: #161b22;
            color: #c9d1d9;

            font: 600 14px/1.2 Arial, sans-serif;

            box-shadow: 0 8px 24px rgba(0, 0, 0, .24);
            cursor: pointer;
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
            background: #ffffff;
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
    `;

    document.head.appendChild(style);

    const button = document.createElement("button");
    button.id = "theme-toggle";
    button.type = "button";

    const icon = document.createElement("span");
    icon.setAttribute("aria-hidden", "true");

    const label = document.createElement("span");

    button.append(icon, label);

    function applyTheme(nextTheme, savePreference = true) {
        const isLight = nextTheme === "light";

        root.dataset.theme = nextTheme;
        root.style.colorScheme = nextTheme;

        icon.textContent = isLight ? "🌙" : "☀️";
        label.textContent = isLight ? "Tema escuro" : "Tema claro";

        button.setAttribute("aria-pressed", String(isLight));

        button.setAttribute(
            "aria-label",
            isLight
                ? "Alternar para tema escuro"
                : "Alternar para tema claro"
        );

        if (savePreference) {
            try {
                localStorage.setItem(STORAGE_KEY, nextTheme);
            } catch (error) {
                // A troca funciona mesmo sem armazenamento.
            }
        }
    }

    button.addEventListener("click", () => {
        const nextTheme =
            root.dataset.theme === "light" ? "dark" : "light";

        applyTheme(nextTheme);
    });

    function initialize() {
        if (!document.body.contains(button)) {
            document.body.appendChild(button);
        }

        applyTheme(theme, false);
    }

    if (document.readyState === "loading") {
        document.addEventListener(
            "DOMContentLoaded",
            initialize,
            { once: true }
        );
    } else {
        initialize();
    }
})();
