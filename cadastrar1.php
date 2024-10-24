<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Medicamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #cce7ff; /* Azul claro */
            color: black; /* Cor do texto em preto para contraste */
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Fundo branco semitransparente */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
    <?php
    function conectarBanco() {
        $host = 'localhost';
        $db = 'farmacia';
        $user = 'root';
        $pass = 'cimatec';
        try {
            $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
            exit;
        }
    }
    
    // CADASTRAR MEDICAMENTOS
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar'])) {
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];
        $categoria = $_POST['categoria'];
        $validade = $_POST['validade'];
        $conn = conectarBanco();
        $sql = "INSERT INTO medicamentos (nome, preco, quantidade, categoria, validade) VALUES (:nome, :preco, :quantidade, :categoria, :validade)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':validade', $validade);
        try {
            $stmt->execute();
            $sucesso = "Medicamento cadastrado com sucesso!";
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar medicamento: " . $e->getMessage();
        }
    }

    // LISTAR MEDICAMENTOS
    function listarMedicamentos() {
        $conn = conectarBanco();
        $sql = "SELECT * FROM medicamentos ORDER BY nome ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $medicamentos = listarMedicamentos();
    ?>
</head>
<body>
    <div class="container mt-5">
        <div class="header-image text-center mb-4">
            <img src="https://via.placeholder.com/800x200.png?text=Bem-vindo+à+Farmácia+da+Emmy" alt="Farmácia">
        </div>
        <h2>Cadastrar Medicamento</h2>
        <?php if(isset($sucesso)): ?>
            <div class="alert alert-success"><?php echo $sucesso; ?></div>
        <?php endif; ?>
        <?php if(isset($erro)): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Medicamento</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço de Custo</label>
                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
            </div>
            <div class="mb-3">
                <label for="quantidade" class="form-label">Quantidade em Estoque</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <option value="Analgésico">Analgésico</option>
                    <option value="Antivirais">Antivirais</option>
                    <option value="Anti-inflamatórios">Anti-inflamatórios</option>
                    <option value="Antitérmicos">Antitérmicos</option>
                    <option value="Antialérgicos">Antialérgicos</option>
                    <option value="Antibióticos">Antibióticos</option>
                    <option value="Antigripais">Antigripais</option>
                    <option value="Antidepressivos">Antidepressivos</option>
                    <option value="Antifúngicos">Antifúngicos</option>
                    <option value="Vitaminas">Vitaminas</option>
                    <option value="Higiene Pessoal">Higiene Pessoal</option>
                    <option value="Dermatologicos">Dermatologicos</option>
                    <option value="Suplementos">Suplementos</option>
                    <option value="Primeiros Socorros">Primeiros Socorros</option>
                    <option value="Ansiolíticos">Ansiolíticos</option>
                    <option value="Antihipertensivos">Antihipertensivos</option>
                    <option value="Antipiréticos">Antipiréticos</option>
                    <option value="Anticonvulsivantes">Anticonvulsivantes</option>
                    <option value="Anticoncepcionais">Anticoncepcionais</option>
                    <option value="Broncodilatadores">Broncodilatadores</option>
                    <option value="Diuréticos">Diuréticos</option>
                    <option value="Estatinas">Estatinas</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="data_validade" class="form-label">Data de Validade</label>
                <input type="date" class="form-control" id="data_validade" name="data_validade" required>
            </div>
            <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
        </form>

        <h2 class="mt-5">Lista de Medicamentos</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço