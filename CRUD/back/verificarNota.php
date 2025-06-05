<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Nota</title>
    <link rel="stylesheet" href="../estilos/styleVerificar.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Início</a></li>
                <li><a href="cadastro.php">Cadastrar Usuário</a></li>
                <li><a href="">Listas Usuários</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="containerSection">
            <form action="verificarNota.php" method="post">
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
                //Verificar se o $POST['CURSO'] está vazio
                if (isset($_POST['genero'])) {

                    //Chamar a conexão com o DB
                    include("../conexao/conexao.php");

                    //Salvar a informação do curso selecionado
                    $genero = $_POST['genero'];

                    //Consulta no SQL
                    $sql = "SELECT * FROM musicas WHERE genero = ?";

                    //Preparar a consulta SQL junto da conexão
                    $stmt = $conn->prepare($sql);

                    //Verificar se a conexão foi feita com sucesso
                    if ($stmt) {
                        $stmt->bind_param("s", $curso);
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
                                            <td>{$row['ID']}</td>
                                            <td>{$row['ARTISTA']}</td>
                                            <td>{$row['NOME']}</td>
                                            <td>{$row['ALBUM']}</td>
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