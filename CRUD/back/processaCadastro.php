<?php
    include("../conexao/conexao.php");
    $nomes = $_POST['nome'];
    $albuns = $_POST['album'];

    foreach ($nomes as $id => $nome){
        $album = $albuns[$id];

        $sql = "UPDATE musicas SET nome = ?, album = ? WHERE id = ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nome, $album, $id);
        $stmt->execute();
    };
    $stmt->close();
    $conn->close();
    header("Location: atualizarCadastro.php");
?>