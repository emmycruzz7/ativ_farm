<?php 
    require 'conexao1.php';
    $id = $_POST['id'];

    $sql = $pdo->prepare("DELETE FROM medicamentos WHERE id = :id");
    $sql->bindValue(':id', $id);
   
    $sql->execute();
    
    header("Location: cadastrar1.php");
?>
