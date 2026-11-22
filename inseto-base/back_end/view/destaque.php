<?php
include '../config/banco.php';

$sqlDestaques = "SELECT * FROM insetos WHERE destaque = 1 LIMIT 6";
$stmtDestaques = $pdo->query($sqlDestaques);
$destaques = $stmtDestaques->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destaques - Wiki Invertebrados</title>
    <link rel="stylesheet" href="../../front_end/c.css">
</head>
<body>
    <header class="wiki-header">
        <div class="logo-area">
            <h1>🐛 Wiki Invertebrados</h1>
            <p>Enciclopédia digital de invertebrados</p>
        </div>
        <nav class="topo-nav">
            <a href="index.php" class="ativo">Início</a>
            <a href="categoria.php">Categorias</a>
            <a href="habitat.php">Habitats</a>
            <a href="sobre.php">Sobre</a>
        </nav>
    </header>

    <div class="wiki-container">
        <main class="wiki-content">
            <section class="artigo-bloco">
                <h2>Artigos em Destaque</h2>
                <p>Conheça as espécies mais fascinantes e curiosas selecionadas para a nossa vitrine.</p>

                <?php if (count($destaques) > 0) { ?>
                    <div class="grid-categorias">
                        <?php foreach ($destaques as $item) { ?>
                            <div class="card-categoria">
                                <span style="font-size: 0.75rem; background-color: var(--cor-superficie-2); color: var(--cor-destaque-claro); padding: 3px 8px; border-radius: var(--raio-pequeno); border: 1px solid var(--cor-borda); text-transform: uppercase; font-weight: 600; display: inline-block; margin-bottom: 8px;">
                                    <?php echo htmlspecialchars($item['ordem_insetos']); ?>
                                </span>

                                <h3><?php echo htmlspecialchars(ucwords($item['nome_insetos'])); ?></h3>

                                <p style="font-style: italic; color: var(--cor-texto-fraco); font-size: 0.85rem; margin-bottom: 10px;">
                                    <?php echo htmlspecialchars($item['nc_insetos']); ?>
                                </p>

                                <p>
                                    <?php
                                    $curiosidade = $item['curisidade'];
                                    echo htmlspecialchars(mb_strlen($curiosidade) > 90 ? mb_substr($curiosidade, 0, 90) . '...' : $curiosidade);
                                    ?>
                                </p>

                                <a href="id.php?id=<?php echo $item['id_insetos']; ?>">
                                    Ver detalhes &rarr;
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <p>Nenhum artigo em destaque no momento.</p>
                <?php } ?>
            </section>
        </main>

        <aside class="wiki-sidebar">
            <div class="sidebar-box">
                <h3>Navegação Rápida</h3>
                <ul>
                    <li><a href="index.php">&larr; Página Inicial</a></li>
                    <li><a href="categoria.php">Explorar Categorias</a></li>
                    <li><a href="habitat.php">Explorar Habitats</a></li>
                </ul>
            </div>
        </aside>
    </div>
</body>
</html>