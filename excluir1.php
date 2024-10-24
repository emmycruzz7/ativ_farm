<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Medicamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e0f7fa; /* azul claro background */
        }
        .container {
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Editar Medicamento</h1>
        <?php 
            require 'conexao1.php';
            $id = $_REQUEST["id"];
            $dados = []; // Para armazenar os dados
            $sql = $pdo->prepare("SELECT * FROM medicamentos WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $dados = $sql->fetch(PDO::FETCH_ASSOC);
            } else {
                header("Location: cadastrar1.php");
                exit;
            }     
        ?>
        <form action="editando1.php" method="POST">
            <input type="hidden" name="id" id="id" value="<?= htmlspecialchars($dados['id']); ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($dados['nome']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço:</label>
                <input type="number" step="0.01" name="preco" class="form-control" value="<?= htmlspecialchars($dados['preco']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="quantidade" class="form-label">Quantidade:</label>
                <input type="number" name="quantidade" class="form-control" value="<?= htmlspecialchars($dados['quantidade']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria:</label>
                <select name="categoria" class="form-select">
                    <option <?= $dados['categoria'] == 'Analgesico' ? 'selected' : ''; ?>>Analgesico</option>
                    <option <?= $dados['categoria'] == 'Antibiotico' ? 'selected' : ''; ?>>Antibiotico</option>
                    <option <?= $dados['categoria'] == 'Anti-inflamatorio' ? 'selected' : ''; ?>>Anti-inflamatorio</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="validade" class="form-label">Validade:</label>
                <input type="date" name="validade" class="form-control" value="<?= htmlspecialchars($dados['validade']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>