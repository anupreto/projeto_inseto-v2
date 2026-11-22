<?php
include '../config/banco.php';

$bioma = isset($_GET['bioma']) ? trim($_GET['bioma']) : '';
$verTodos = isset($_GET['ver']) && $_GET['ver'] === 'todos';
$limiteInicial = 6;

$biomas = [];
$totalBiomas = 0;
$resultados = [];

if (empty($bioma)) {
    $sqlTotalBiomas = "SELECT COUNT(DISTINCT bioma_habitats) 
                       FROM habitats 
                       WHERE bioma_habitats IS NOT NULL AND bioma_habitats != ''";
    $totalBiomas = (int) $pdo->query($sqlTotalBiomas)->fetchColumn();

    $sqlBiomas = "SELECT bioma_habitats, COUNT(*) as total 
                  FROM habitats 
                  WHERE bioma_habitats IS NOT NULL AND bioma_habitats != '' 
                  GROUP BY bioma_habitats 
                  ORDER BY total DESC, bioma_habitats ASC";
    if (!$verTodos) {
        $sqlBiomas .= " LIMIT " . (int) $limiteInicial;
    }

    $stmtBiomas = $pdo->query($sqlBiomas);
    $biomas = $stmtBiomas->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT h.*, i.id_insetos, i.nome_insetos, i.nc_insetos, i.ordem_insetos 
            FROM habitats h
            INNER JOIN insetos i ON h.id_insetos = i.id_insetos
            WHERE h.bioma_habitats = :bioma
            ORDER BY i.nome_insetos ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['bioma' => $bioma]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo empty($bioma) ? 'Habitats' : 'Bioma: ' . htmlspecialchars($bioma); ?> - Wiki Invertebrados</title>
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
            <a href="habitat.php" class="ativo">Habitats</a>
            <a href="sobre.php">Sobre</a>
        </nav>
    </header>

    <div class="wiki-container">
        <main class="wiki-content">

            <?php if (empty($bioma)) { ?>
                <section class="artigo-bloco">
                    <h2>Explorar por Habitats e Biomas</h2>
                    <p>
                        <?php echo $verTodos
                            ? 'Exibindo todos os ' . $totalBiomas . ' biomas cadastrados:'
                            : 'Mostrando os principais biomas (' . count($biomas) . ' de ' . $totalBiomas . ') para manter a visualização limpa:'; ?>
                    </p>
                </section>

                <section class="artigo-bloco">
                    <?php if (count($biomas) > 0) { ?>
                        <div class="grid-categorias">
                            <?php foreach ($biomas as $b) { ?>
                                <div class="card-categoria">
                                    <h3><?php echo htmlspecialchars($b['bioma_habitats']); ?></h3>
                                    <p><?php echo $b['total']; ?> registro(s) associado(s)</p>
                                    <a href="habitat.php?bioma=<?php echo urlencode($b['bioma_habitats']); ?>">Ver espécies &rarr;</a>
                                </div>
                            <?php } ?>
                        </div>

                        <?php if (!$verTodos && $totalBiomas > $limiteInicial) { ?>
                            <div style="margin-top: 20px; text-align: center;">
                                <a href="habitat.php?ver=todos" style="color: var(--cor-destaque-claro); text-decoration: none; font-weight: 600; display: inline-block; padding: 9px 16px; background-color: var(--cor-superficie-2); border: 1px solid var(--cor-borda-forte); border-radius: var(--raio-pequeno);">
                                    Ver todos os biomas (+<?php echo $totalBiomas - $limiteInicial; ?>)
                                </a>
                            </div>
                        <?php } elseif ($verTodos && $totalBiomas > $limiteInicial) { ?>
                            <div style="margin-top: 20px; text-align: center;">
                                <a href="habitat.php" style="color: var(--cor-texto-suave); text-decoration: none; font-size: 0.9rem;">
                                    &larr; Ocultar extras e mostrar principais
                                </a>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p>Nenhum habitat cadastrado no banco de dados ainda.</p>
                    <?php } ?>
                </section>

            <?php } else { ?>
                <section class="artigo-bloco">
                    <h2>Bioma: <?php echo htmlspecialchars($bioma); ?></h2>
                    <p>Encontramos <strong><?php echo count($resultados); ?></strong> espécie(s) associada(s) a este bioma:</p>
                </section>

                <section class="artigo-bloco">
                    <?php if (count($resultados) > 0) { ?>
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <?php foreach ($resultados as $row) { ?>
                                <div class="card-categoria" style="transform: none;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 8px;">
                                        <a href="id.php?id=<?php echo $row['id_insetos']; ?>" style="color: var(--cor-destaque-claro); text-decoration: none; font-weight: 600; font-size: 1.1rem;">
                                            <?php echo htmlspecialchars(ucwords($row['nome_insetos'])); ?>
                                        </a>
                                        <span style="background-color: var(--cor-fundo); color: var(--cor-secundaria); padding: 3px 10px; border-radius: 999px; font-size: 0.8rem; border: 1px solid var(--cor-borda);">
                                            Clima: <?php echo htmlspecialchars($row['clima_habitats']); ?>
                                        </span>
                                    </div>
                                    <p style="font-size: 0.85rem; font-style: italic; margin-bottom: 8px;">
                                        <?php echo htmlspecialchars($row['nc_insetos']); ?> — Habitat: <?php echo htmlspecialchars($row['nome_habitats']); ?>
                                    </p>
                                    <p style="font-size: 0.92rem; margin: 0;">
                                        <?php echo htmlspecialchars($row['descricao_habitats']); ?>
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>Nenhuma espécie encontrada para este bioma.</p>
                    <?php } ?>
                </section>

                <div style="margin-top: 10px;">
                    <a href="habitat.php" style="color: var(--cor-secundaria); text-decoration: none; font-size: 0.92rem; font-weight: 600;">&larr; Voltar para todos os biomas</a>
                </div>
            <?php } ?>

        </main>

        <aside class="wiki-sidebar">
            <div class="sidebar-box">
                <h3>Navegação Rápida</h3>
                <ul>
                    <li><a href="index.php">&larr; Página Inicial</a></li>
                    <li><a href="categoria.php">Ver Categorias</a></li>
                    <li><a href="habitat.php">Ver Habitats</a></li>
                </ul>
            </div>
        </aside>
    </div>
</body>
</html>