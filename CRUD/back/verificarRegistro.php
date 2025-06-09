<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Registros</title>
    <link href="https://fonts.googleapis.com/css2?family=Limelight&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alumni+Sans+Pinstripe:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Combo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/styleVerificar.css">
</head>
<body>
    <video autoplay muted loop id="bg-video">
        <source src="https://cdn.pixabay.com/video/2022/02/11/107465-678258871_large.mp4" type="video/mp4">
        Seu navegador não suporta vídeo em HTML5.
    </video>
    
    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="cadastro.php">Registrar Músicas</a></li>
                <li><a href="verificarRegistro.php">Verificar Playlists</a></li>
                <li><a href="atualizarArtista.php">Atualizar Playlists</a></li>
                <li><a href="verificarGenero.php">Consulta por gênero</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <section id="containerSection">
            <form action="verificarRegistro.php" method="post">
            <p>Aqui você pode consultar as informações registradas pelo nome do seu artista.</p>
                <label for="artista">Informe o nome do artista abaixo</label>
                <input type="text" placeholder="Ex: Gisem" name="artista" id="artista" required>
                <input type="submit" value="Buscar">
            </form>
        </section>

        <section>
            <?php
            if(isset($_POST["artista"])) { 
                $artista = $_POST["artista"];
                include("../conexao/conexao.php");
                $sql = "SELECT * FROM musicas WHERE artista = ?";
                $stmt = $conn->prepare($sql);
                
                if($stmt){
                    $stmt->bind_param("s", $artista);
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    
                    if ($resultado->num_rows > 0) {
                        $row = $resultado->fetch_assoc();
                        echo "
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Artista</th>
                                        <th>Nome da Música</th>
                                        <th>Álbum</th>
                                        <th>Excluir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>{$row['id']}</td>
                                    <td>{$row['artista']}</td>
                                    <td>{$row['nome']}</td>
                                    <td>{$row['album']}</td>
                                    <td>
                                        <form action='excluirCadastro.php' method='post'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <input type='submit' id='btn-excluir' value='Excluir'>
                                        </form>
                                    </td>
                                </tbody>
                            </table>";
                    } else {
                        echo "<div class='mensagem erro'> Artista $artista não encontrado </div>";
                    }
                    $stmt->close();
                } else {
                    echo "<div class='mensagem erro'>Erro na consulta </div>";
                }
                $conn->close();
            }
            ?>
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>