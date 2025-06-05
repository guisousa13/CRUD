<?php
    include("../conexao/conexao.php");
    $datalan = $_POST['data_lancamento'];
    $dataregis = $_POST['data_registro'];

    foreach ($datalan as $id => $datal){
        $dataregis = $datalan[$id];

        $sql = "UPDATE musicas SET DATA_LANCAMENTO = ?, DATA_REGISTRO = ? WHERE ID = ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dddi", $datalan, $dataregis, $id);
        $stmt->execute();
    };
    $stmt->close();
    $conn->close();
    header("Location: atualizarArtista.php");
?>