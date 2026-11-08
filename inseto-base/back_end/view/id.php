 <?php
      try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=insetos_db;charset=utf8", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

$id = isset($_GET['id']) ? $_GET['id'] : 1;

$sql = "SELECT * FROM insetos WHERE id_insetos = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();

$linha = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$linha) {
    $linha = [
        'nome_insetos' => 'Inseto não encontrado',
        'nc_insetos' => 'Desconhecido',
        'familia_insetos' => 'Desconhecida',
        'ordem_insetos' => 'Não informada',
        'dieta_insetos' => 'Não informada',
        'curisidade' => 'Não há registros para este inseto no laboratório.'
    ];
} 
    ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wiki - <?php echo $linha['nome_insetos'];?></title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #0d1117;
            color: #c9d1d9;
            padding: 30px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            line-height: 1.6;
        }

        .card-confortavel {
            background-color: #161b22;
            border: 1px solid #30363d;
            width: 100%;
            max-width: 750px;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .card-titulo h1 {
            font-size: 1.8rem;
            color: #58a6ff;
            font-weight: 600;
            border-bottom: 1px solid #21262d;
            padding-bottom: 12px;
        }

        .conteudo-principal {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }

        .foto-inseto {
            flex: 1;
            min-width: 240px;
            height: 260px;
            background-color: #21262d;
            border-radius: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            color: #8b949e;
            font-weight: 500;
            border: 2px dashed #30363d;
            position: relative;
        }

        .foto-inseto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .foto-inseto span {
            z-index: 0;
        }

        .ficha-tecnica {
            flex: 1.3;
            min-width: 240px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 12px;
        }

        .dado-item {
            font-size: 1rem;
            color: #b1bac4;
        }

        .dado-item strong {
            color: #ffffff;
        }

        .bloco-curiosidade {
            background-color: #21262d;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #30363d;
            border-left: 4px solid #58a6ff;
        }

        .bloco-curiosidade h3 {
            font-size: 1.1rem;
            color: #58a6ff;
            margin-bottom: 8px;
        }

        .bloco-curiosidade p {
            font-size: 0.95rem;
            color: #b1bac4;
            line-height: 1.6;
        }

        .btn-voltar {
            align-self: flex-start;
            text-decoration: none;
            background-color: #21262d;
            border: 1px solid #30363d;
            color: #58a6ff;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .btn-voltar:hover {
            background-color: #30363d;
            border-color: #58a6ff;
        }
    </style>
</head>
<body>

    <div class="card-confortavel">
        
        <div class="card-titulo">
            <h1><?php echo $linha['nome_insetos']; ?></h1>
        </div>

        <div class="conteudo-principal">
            
            <div class="foto-inseto">
                 <img src="<?php echo $linha['foto_insetos']; ?>" alt="Inseto">
                <span>Foto do Inseto</span>
            </div>

            <div class="ficha-tecnica">
                <div class="dado-item">
                    <strong>Nome Científico:</strong> <em><?php echo $linha['nc_insetos']; ?></em>
                </div>
                <div class="dado-item">
                    <strong>Família:</strong> <?php echo $linha['familia_insetos']; ?>
                </div>
                <div class="dado-item">
                    <strong>Ordem:</strong> <?php echo $linha['ordem_insetos']; ?>
                </div>
                <div class="dado-item">
                    <strong>Alimentação:</strong> <?php echo $linha['dieta_insetos']; ?>
                </div>
            </div>

        </div>

        <div class="bloco-curiosidade">
            <h3>Curiosidades</h3>
            <p><?php echo $linha['curisidade']; ?></p>
        </div>

        <a href="index.php" class="btn-voltar">Voltar para a Home</a>

    </div>

</body>
</html>