<?php
include '../config/banco.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

$sql = "SELECT * FROM insetos WHERE id_insetos = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$linha = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$linha) {
    $linha = [
        'nome_insetos' => 'Espécie não encontrada',
        'nc_insetos' => 'Desconhecido',
        'familia_insetos' => 'Desconhecida',
        'ordem_insetos' => 'Não informada',
        'dieta_insetos' => 'Não informada',
        'foto_insetos' => '',
        'curisidade' => 'Não há registros para esta espécie no banco.'
    ];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wiki - <?php echo htmlspecialchars(ucwords($linha['nome_insetos'])); ?></title>
    <link rel="stylesheet" href="../../front_end/c.css">
    <style>
        .ficha-wrapper {
            max-width: 820px;
            margin: 20px auto;
        }
        .conteudo-principal {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .foto-inseto {
            flex: 1;
            min-width: 240px;
            height: 260px;
            background-color: var(--cor-superficie-2);
            border-radius: var(--raio-folha);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            color: var(--cor-texto-fraco);
            font-weight: 500;
            border: 1px dashed var(--cor-borda-forte);
            position: relative;
        }
        .foto-inseto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: relative;
            z-index: 1;
        }
        .ficha-tecnica {
            flex: 1.3;
            min-width: 240px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 10px;
        }
        .dado-item {
            font-size: 0.98rem;
            color: var(--cor-texto-suave);
            background-color: var(--cor-superficie-2);
            padding: 10px 14px;
            border-radius: var(--raio-pequeno);
            border: 1px solid var(--cor-borda);
        }
        .dado-item strong {
            color: var(--cor-destaque-claro);
        }
        .bloco-curiosidade {
            background-color: var(--cor-superficie-2);
            padding: 18px 20px;
            border-radius: var(--raio-pequeno);
            border: 1px solid var(--cor-borda);
            border-left: 3px solid var(--cor-destaque);
            margin-bottom: 20px;
        }
        .bloco-curiosidade h3 {
            font-family: var(--fonte-titulo);
            font-size: 1.1rem;
            color: var(--cor-destaque);
            margin-bottom: 8px;
        }
        .btn-voltar-folha {
            display: inline-block;
            text-decoration: none;
            background-color: var(--cor-superficie-2);
            border: 1px solid var(--cor-borda-forte);
            color: var(--cor-destaque-claro);
            padding: 9px 18px;
            border-radius: var(--raio-pequeno);
            font-weight: 600;
            font-size: 0.9rem;
        }
        .btn-voltar-folha:hover {
            background-color: var(--cor-borda);
        }
    </style>
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

    <main class="ficha-wrapper">
        <section class="artigo-bloco">
            <h2><?php echo htmlspecialchars(ucwords($linha['nome_insetos'])); ?></h2>

            <div class="conteudo-principal">
                <div class="foto-inseto">
                    <?php if (!empty($linha['foto_insetos'])) { ?>
                        <img src="<?php echo htmlspecialchars($linha['foto_insetos']); ?>" alt="<?php echo htmlspecialchars($linha['nome_insetos']); ?>">
                    <?php } else { ?>
                        <span>Sem foto cadastrada</span>
                    <?php } ?>
                </div>

                <div class="ficha-tecnica">
                    <div class="dado-item">
                        <strong>Nome Científico:</strong> <em><?php echo htmlspecialchars($linha['nc_insetos']); ?></em>
                    </div>
                    <div class="dado-item">
                        <strong>Família:</strong> <?php echo htmlspecialchars($linha['familia_insetos']); ?>
                    </div>
                    <div class="dado-item">
                        <strong>Ordem:</strong> <?php echo htmlspecialchars(ucwords($linha['ordem_insetos'])); ?>
                    </div>
                    <div class="dado-item">
                        <strong>Alimentação:</strong> <?php echo htmlspecialchars($linha['dieta_insetos']); ?>
                    </div>
                </div>
            </div>

            <div class="bloco-curiosidade">
                <h3>Curiosidades</h3>
                <p><?php echo htmlspecialchars($linha['curisidade']); ?></p>
            </div>

            <a href="index.php" class="btn-voltar-folha">&larr; Voltar para a Home</a>
        </section>
    </main>
</body>
</html>