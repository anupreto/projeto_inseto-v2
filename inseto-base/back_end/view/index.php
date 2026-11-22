<?php
include '../config/banco.php';

$sqlTotal = "SELECT COUNT(*) as total FROM insetos";
$totalInsetos = $pdo->query($sqlTotal)->fetch(PDO::FETCH_ASSOC)['total'];

$diaDoAno = (int) date('z') + 1;
$idSorteado = ($diaDoAno % $totalInsetos);
if ($idSorteado == 0) {
    $idSorteado = $totalInsetos;
}

$sqlCuriosidade = "SELECT nome_insetos, nc_insetos, curisidade, foto_insetos FROM insetos WHERE id_insetos = :id";
$stmtCuriosidade = $pdo->prepare($sqlCuriosidade);
$stmtCuriosidade->execute(['id' => $idSorteado]);
$curiosidadeDiaria = $stmtCuriosidade->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wiki Invertebrados</title>
    <link rel="stylesheet" href="../../front_end/c.css">
</head>
<body>
    <header class="wiki-header">
        <div class="logo-area">
            <h1>🐛 Wiki Invertebrados</h1>
            <p>A enciclopédia digital do reino animal sem espinha</p>
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
                <h2>Introdução aos Invertebrados</h2>
                <p>Os <strong>invertebrados</strong> representam cerca de 95% de todas as espécies animais conhecidas no planeta Terra. Eles habitam praticamente todos os ecossistemas imagináveis, desde as fossas oceânicas mais profundas até o topo das montanhas, desempenhando papéis ecológicos cruciais como polinizadores, recicladores de nutrientes e base da cadeia alimentar global.</p>
                <p>Diferente dos vertebrados, esses animais não possuem coluna vertebral ou crânio ósseo, exibindo uma diversidade morfológica impressionante que vai desde corpos gelatinosos até exoesqueletos altamente resistentes.</p>
            </section>

            <section class="artigo-bloco">
                <h2>Principais Grupos Taxonômicos</h2>
                <p>Abaixo estão os grandes troncos que estruturam o estudo da biodiversidade nesta enciclopédia:</p>
                
                <div class="grid-categorias">
                    <div class="card-categoria">
                        <h3>Aracnídeos</h3>
                        <p>Aranhas, escorpiões, ácaros e carrapatos. Oito patas e predadores natos.</p>
                        <a href="artigo.php?grupo=aracnideos">Ver artigos &rarr;</a>
                    </div>
                    <div class="card-categoria">
                        <h3>Insetos</h3>
                        <p>A classe mais numerosa da Terra. Corpo dividido em três partes e asas.</p>
                        <a href="artigo.php?grupo=insetos">Ver artigos &rarr;</a>
                    </div>
                    <div class="card-categoria">
                        <h3>Crustáceos</h3>
                        <p>Caranguejos, camarões e lagostas. Exclusivamente aquáticos em sua maioria.</p>
                        <a href="artigo.php?grupo=crustaceos">Ver artigos &rarr;</a>
                    </div>
                    <div class="card-categoria">
                        <h3>Moluscos</h3>
                        <p>Polvos, lulas e caramujos. Corpos moles e alta inteligência evolutiva.</p>
                        <a href="artigo.php?grupo=moluscos">Ver artigos &rarr;</a>
                    </div>
                    <div class="card-categoria">
                        <h3>Cnidários</h3>
                        <p>Águas-vivas, corais e anêmonas. Mestres gelatinosos dos oceanos.</p>
                        <a href="artigo.php?grupo=cnidarios">Ver artigos &rarr;</a>
                    </div>
                    <div class="card-categoria">
                        <h3>Equinodermos</h3>
                        <p>Estrelas-do-mar e ouriços. Simetria radial e vida marinha fascinante.</p>
                        <a href="artigo.php?grupo=equinodermos">Ver artigos &rarr;</a>
                    </div>
                </div>
            </section>
        </main>

        <aside class="wiki-sidebar">
            <div class="sidebar-box">
                <h3>Navegação Rápida</h3>
                <ul>
                    <li><a href="destaque.php">Artigos em Destaque</a></li>
                    <li><a href="ultima.php">Últimas Edições</a></li>
                    <li><a href="estatistica.php">Estatísticas do Banco</a></li>
                    <li><a href="habitat.php">Explorar Habitats</a></li>
                </ul>
            </div>

            <div class="sidebar-box" style="border-left: 3px solid var(--cor-destaque);">
                <h3>Curiosidade do Dia (<?php echo date('d/m'); ?>)</h3>
                
                <?php if ($curiosidadeDiaria) { ?>
                    <?php if (!empty($curiosidadeDiaria['foto_insetos'])) { ?>
                        <img src="<?php echo htmlspecialchars($curiosidadeDiaria['foto_insetos']); ?>" alt="<?php echo htmlspecialchars($curiosidadeDiaria['nome_insetos']); ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: var(--raio-pequeno); border: 1px solid var(--cor-borda); margin-bottom: 10px;">
                    <?php } ?>
                    <h4 style="margin: 6px 0 4px 0; color: var(--cor-destaque-claro); font-family: var(--fonte-titulo); font-size: 1.02rem;"><?php echo htmlspecialchars($curiosidadeDiaria['nome_insetos']); ?></h4>
                    <p style="font-style: italic; color: var(--cor-texto-fraco); font-size: 0.85rem; margin-bottom: 10px;">
                        <?php echo htmlspecialchars($curiosidadeDiaria['nc_insetos']); ?>
                    </p>
                    <p style="color: var(--cor-texto-suave); font-size: 0.92rem; line-height: 1.55;">
                        "<?php echo htmlspecialchars($curiosidadeDiaria['curisidade']); ?>"
                    </p>
                <?php } else { ?>
                    <p>Nenhuma curiosidade encontrada para hoje.</p>
                <?php } ?>
            </div>
        </aside>
    </div>
    
    <script src="../../front_end/j.js"></script>
</body>
</html>
<!-- http://localhost/inseto-base/back_end/view/index.php -- página principal -->