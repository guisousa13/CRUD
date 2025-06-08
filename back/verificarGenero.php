<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Nota</title>
    <link rel="stylesheet" href="../estilos/styleVerificarGenero.css">
    <link href="https://fonts.googleapis.com/css2?family=Limelight&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alumni+Sans+Pinstripe:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Combo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Combo&display=swap" rel="stylesheet">
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
            
            <form action="verificarGenero.php" method="post">
                <p>Consulte suas músicas pelo gênero</p>
                <select name="genero" id="genero">
                    <option value="pop">Pop</option>
                    <option value="rock">Rock</option>
                    <option value="sertanejo">Sertanejo</option>
                    <option value="funk">Funk</option>
                 </select>
                <input type="submit" value="Buscar">
            </form>
        </section>
        <section>

            <?php
                //Verificar se o $POST['genero'] está vazio
                if (isset($_POST['genero'])) {

                    //Chamar a conexão com o DB
                    include("../conexao/conexao.php");

                    //Salvar a informação do genero selecionado
                    $genero = $_POST['genero'];

                    //Consulta no SQL
                    $sql = "SELECT * FROM musicas WHERE genero = ?";

                    //Preparar a consulta SQL junto da conexão
                    $stmt = $conn->prepare($sql);

                    //Verificar se a conexão foi feita com sucesso
                    if ($stmt) {
                        $stmt->bind_param("s", $genero);
                        $stmt->execute();
                        $resultado = $stmt->get_result();
                        
                        if ($resultado->num_rows > 0) {
                        echo "
                            <table>
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Artista</td>
                                        <td>Nome</td>
                                        <td>Album</td>
                                    </tr>
                                </thead>
                                <tbody> ";
                                    while ($row = $resultado->fetch_assoc()){
                                    echo "
                                        <tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['artista']}</td>
                                            <td>{$row['nome']}</td>
                                            <td>{$row['album']}</td>
                                        </tr> ";
                                    }
                            echo "
                                </tbody>
                            </table>
                            ";
                            } else {
                                echo "<div class='mensagem erro'>O gênero $genero não possui registros</div>";
                            }
                            $stmt->close();
                        }

                        $conn->close();
                }
            ?>
        </section>
    </main>
</body>
</html>