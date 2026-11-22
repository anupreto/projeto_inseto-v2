<?php
include '../config/banco.php';

$sqlTotal = "SELECT COUNT(*) as total FROM insetos";
$totalInsetos = $pdo->query($sqlTotal)->fetch(PDO::FETCH_ASSOC)['total'];

$sqlOrdens = "SELECT ordem_insetos, COUNT(*) as quantidade FROM insetos WHERE ordem_insetos IS NOT NULL AND ordem_insetos != '' GROUP BY ordem_insetos";
$estatisticasOrdens = $pdo->query($sqlOrdens)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas - Wiki Invertebrados</title>
    <link rel="stylesheet" href="../../front_end/c.css">
</head>
<body>
    <header class="wiki-header">
        <div class="logo-area">
            <h1>🐛 Wiki Invertebrados</h1>
            <p>Enciclopédia digital de invertebrados</p>
        </div>
        <nav class="topo-nav">
            <a href="index.php">Início</a>
            <a href="categoria.php">Categorias</a>
            <a href="habitat.php">Habitats</a>
            <a href="sobre.php">Sobre</a>
        </nav>
    </header>

    <div class="wiki-container">
        <main class="wiki-content">
            <section class="artigo-bloco">
                <h2>Estatísticas da Enciclopédia</h2>
                <p>Panorama geral dos dados armazenados no banco:</p>

                <div class="grid-categorias">
                    <div class="card-categoria" style="text-align: center;">
                        <span style="color: var(--cor-texto-fraco); font-size: 0.8rem; text-transform: uppercase; font-weight: 600;">Total de Espécies</span>
                        <h3 style="color: var(--cor-destaque-claro); font-size: 2rem; margin: 6px 0 0 0;"><?php echo $totalInsetos; ?></h3>
                    </div>

                    <?php foreach ($estatisticasOrdens as $ordem) { ?>
                        <div class="card-categoria" style="text-align: center;">
                            <span style="color: var(--cor-texto-fraco); font-size: 0.8rem; text-transform: uppercase; font-weight: 600;"><?php echo htmlspecialchars(ucwords($ordem['ordem_insetos'])); ?></span>
                            <h3 style="color: var(--cor-destaque-claro); font-size: 2rem; margin: 6px 0 0 0;"><?php echo $ordem['quantidade']; ?></h3>
                        </div>
                    <?php } ?>
                </div>
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