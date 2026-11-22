<?php
include '../config/banco.php';

$ultimas = "SELECT * FROM insetos ORDER BY id_insetos DESC LIMIT 5";
$stmtUltimas = $pdo->query($ultimas);
$edicaoUltima = $stmtUltimas->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Últimas Edições - Wiki Invertebrados</title>
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
                <h2>Últimas Edições</h2>
                <p>Espécies que acabaram de entrar para a nossa enciclopédia:</p>

                <?php if (count($edicaoUltima) > 0) { ?>
                    <ul style="list-style: none; padding: 0; margin-top: 15px; display: flex; flex-direction: column; gap: 10px;">
                        <?php foreach ($edicaoUltima as $item) { ?>
                            <li style="background-color: var(--cor-superficie-2); padding: 12px 16px; border-radius: var(--raio-pequeno); border: 1px solid var(--cor-borda); border-left: 3px solid var(--cor-destaque); display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                                <a href="id.php?id=<?php echo $item['id_insetos']; ?>" style="color: var(--cor-destaque-claro); text-decoration: none; font-weight: 600;">
                                    <?php echo htmlspecialchars(ucwords($item['nome_insetos'])); ?>
                                </a>

                                <span style="font-size: 0.78rem; background-color: var(--cor-fundo); color: var(--cor-secundaria); padding: 3px 9px; border-radius: 999px; border: 1px solid var(--cor-borda);">
                                    <?php echo htmlspecialchars(ucwords($item['ordem_insetos'])); ?>
                                </span>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>Nenhuma edição recente encontrada.</p>
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