<?php
include '../config/banco.php';

$verTudo = false;
$insetos = [];
$categorias = [];
$totalEspecies = 0;

$porPagina = 8;
$paginaAtual = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;
$totalPaginas = 1;

$ordem = isset($_GET['ordem']) ? trim($_GET['ordem']) : '';

if (empty($ordem)) {
    $sqlCat = "SELECT ordem_insetos, COUNT(*) as total FROM insetos WHERE ordem_insetos IS NOT NULL AND ordem_insetos != '' GROUP BY ordem_insetos";
    $stmtCat = $pdo->query($sqlCat);
    $categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
} else {
    $verTudo = isset($_GET['ver']) && $_GET['ver'] === 'tudo';

    $sqlCount = "SELECT COUNT(*) FROM insetos WHERE ordem_insetos = :ordem";
    $stmtCount = $pdo->prepare($sqlCount);
    $stmtCount->execute(['ordem' => $ordem]);
    $totalEspecies = (int) $stmtCount->fetchColumn();

    $totalPaginas = max(1, (int) ceil($totalEspecies / $porPagina));
    if ($paginaAtual > $totalPaginas) {
        $paginaAtual = $totalPaginas;
    }

    $offset = ($paginaAtual - 1) * $porPagina;

    if ($verTudo) {
        $sql = "SELECT * FROM insetos WHERE ordem_insetos = :ordem ORDER BY nome_insetos ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['ordem' => $ordem]);
    } else {
        $sql = "SELECT * FROM insetos WHERE ordem_insetos = :ordem ORDER BY nome_insetos ASC LIMIT :limite OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':ordem', $ordem, PDO::PARAM_STR);
        $stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    }

    $insetos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo empty($ordem) ? 'Categorias' : 'Categoria: ' . htmlspecialchars(ucwords($ordem)); ?> - Wiki Invertebrados</title>
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
            <a href="categoria.php" class="ativo">Categorias</a>
            <a href="habitat.php">Habitats</a>
            <a href="sobre.php">Sobre</a>
        </nav>
    </header>

    <div class="wiki-container">
        <main class="wiki-content">
            <?php if (empty($ordem)) { ?>
                <section class="artigo-bloco">
                    <h2>Explorar por Categorias (Ordens)</h2>
                    <p>Selecione abaixo uma ordem de invertebrados para ver as espécies cadastradas:</p>
                </section>

                <section class="artigo-bloco">
                    <?php if (count($categorias) > 0) { ?>
                        <div class="grid-categorias">
                            <?php foreach ($categorias as $cat) { ?>
                                <div class="card-categoria">
                                    <h3><?php echo htmlspecialchars(ucwords($cat['ordem_insetos'])); ?></h3>
                                    <p><?php echo $cat['total']; ?> espécie(s) cadastrada(s)</p>
                                    <a href="categoria.php?ordem=<?php echo urlencode($cat['ordem_insetos']); ?>">Ver espécies &rarr;</a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p style="color: var(--cor-texto-suave);">Nenhuma categoria encontrada no banco de dados.</p>
                    <?php } ?>
                </section>
            <?php } else { ?>
                <section class="artigo-bloco">
                    <h2>Espécies da ordem: <?php echo htmlspecialchars(ucwords($ordem)); ?></h2>
                    <p>
                        Atualmente temos <strong><?php echo $totalEspecies; ?></strong> espécies cadastradas nesta categoria.
                        <?php if ($verTudo) { ?>
                            Exibindo todas as espécies:
                        <?php } else { ?>
                            Subpágina <strong><?php echo $paginaAtual; ?></strong> de <strong><?php echo $totalPaginas; ?></strong>:
                        <?php } ?>
                    </p>
                </section>

                <section class="artigo-bloco">
                    <?php if (count($insetos) > 0) { ?>
                        <ul style="list-style-type: none; padding: 0; display: flex; flex-direction: column; gap: 10px;">
                            <?php foreach ($insetos as $row) { ?>
                                <li style="background-color: var(--cor-superficie-2); padding: 12px 15px; border-radius: var(--raio-pequeno); border: 1px solid var(--cor-borda); border-left: 3px solid var(--cor-destaque);">
                                    <a href="id.php?id=<?php echo $row['id_insetos']; ?>" style="color: var(--cor-destaque-claro); text-decoration: none; font-weight: 600;">
                                        <?php echo htmlspecialchars(ucwords($row['nome_insetos'])); ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>

                        <?php if ($totalEspecies > $porPagina) { ?>
                            <div style="margin-top: 22px; display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                <?php if (!$verTudo && $totalPaginas > 1) { ?>
                                    <nav aria-label="Subpáginas da categoria" style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 8px;">
                                        <?php for ($p = 1; $p <= $totalPaginas; $p++) { ?>
                                            <?php $ativa = ($p === $paginaAtual); ?>
                                            <a href="categoria.php?ordem=<?php echo urlencode($ordem); ?>&pagina=<?php echo $p; ?>" style="text-decoration: none; font-weight: 600; font-size: 0.9rem; padding: 6px 12px; border-radius: var(--raio-pequeno); background-color: <?php echo $ativa ? 'var(--cor-destaque)' : 'var(--cor-superficie-2)'; ?>; color: <?php echo $ativa ? 'var(--cor-fundo)' : 'var(--cor-destaque-claro)'; ?>; border: 1px solid <?php echo $ativa ? 'var(--cor-destaque-claro)' : 'var(--cor-borda-forte)'; ?>;">
                                                <?php echo $p; ?>
                                            </a>
                                            <?php if ($p < $totalPaginas) { ?>
                                                <span style="color: var(--cor-texto-fraco); font-weight: 600;">-</span>
                                            <?php } ?>
                                        <?php } ?>
                                    </nav>
                                <?php } ?>

                                <div>
                                    <?php if (!$verTudo) { ?>
                                        <a href="categoria.php?ordem=<?php echo urlencode($ordem); ?>&ver=tudo" style="color: var(--cor-secundaria); text-decoration: none; font-weight: 600; font-size: 0.9rem; padding: 7px 14px; background-color: var(--cor-superficie); border: 1px solid var(--cor-borda); border-radius: var(--raio-pequeno); display: inline-block;">
                                            Ver mais (todas as <?php echo $totalEspecies; ?> espécies)
                                        </a>
                                    <?php } else { ?>
                                        <a href="categoria.php?ordem=<?php echo urlencode($ordem); ?>&pagina=1" style="color: var(--cor-secundaria); text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                                            &larr; Voltar para subpáginas (1 - 2 - ...)
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p style="color: var(--cor-texto-suave);">Nenhuma espécie cadastrada nesta categoria ainda.</p>
                    <?php } ?>
                </section>

                <div style="margin-top: 20px;">
                    <a href="categoria.php" style="color: var(--cor-secundaria); text-decoration: none; font-size: 0.9rem; font-weight: 600;">&larr; Voltar para todas as categorias</a>
                </div>
            <?php } ?>
        </main>

        <aside class="wiki-sidebar">
            <div class="sidebar-box">
                <h3>Navegação Rápida</h3>
                <ul>
                    <li><a href="index.php">&larr; Voltar para a Página Inicial</a></li>
                    <li><a href="categoria.php">Ver Categorias</a></li>
                    <li><a href="habitat.php">Ver Habitats</a></li>
                </ul>
            </div>
        </aside>
    </div>
</body>
</html>