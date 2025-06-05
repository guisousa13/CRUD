<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Música</title>
    <link rel="stylesheet" href="../estilos/styleCadastrar.css">
</head>
<body>

    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Início</a></li>
                <li><a href="">Cadastrar Usuário</a></li>
                <li><a href="verificarCadastro.php">Listas Usuários</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form action="cadastro.php" method="post">
            <h2>Cadastro de Músicas</h2>

            <label for="artista">Nome do Artista:</label>
            <input type="text" name="artista" id="artista" required>

            <label for="nome">Nome da Música:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="album">Álbum:</label>
            <input type="text" name="album" id="album" required>

            <label for="lancamento">Data de Lançamento:</label>
            <input type="date" name="lancamento" id="lancamento" required>

            <label for="genero">Selecione o gênero: </label>
            <select name="genero" id="genero">
                <option value="pop">Pop</option>
                <option value="rock">Rock</option>
                <option value="sertanejo">Sertanejo</option>
                <option value="funk">Funk</option>
            </select>

            <input type="submit" value="Cadastrar">
        </form>

        <?php

            if($_SERVER["REQUEST_METHOD"] == "POST") {

                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                try {
                //capturar um arquivo externo
                include("../conexao/conexao.php");
                
                //Variaveis do usuario
                $artista = $_POST["artista"];
                $nome = $_POST["nome"];
                $album = $_POST["album"];
                $datalan = $_POST["lancamento"];
                $genero = $_POST["genero"];
                $prefixo = "1572";
                $id = $prefixo . rand(100,999);
                
                //Consulta SQL
                $sql = "INSERT INTO musicas (id, artista, nome, album, data_lancamento, genero) VALUES (?, ?, ?, ?, ?, ?)";

                //Preparar a consulta
                $stmt = $conn->prepare($sql);

                //Vincular as variáveis do usuário com a consulta SQL
                $stmt->bind_Param("ssssss" ,$id,$artista, $nome, $album, $datalan, $genero);
                
                //Executar a consulta
                $stmt->execute();

                //Exibindo a mensagem de sucesso
                echo "<div class = 'mensagem sucesso'> Usuário cadastrado com sucesso! </div>";

                //Encerrar a consulta SQL e conexão com banco
                $stmt->close();
                $conn->close();
                }  
                catch(mysqli_sql_exception $e){
                  echo "<div class = 'mensagem erro'> Erro ao cadastrar " . $e->getMessage(). "</div>";
            }
        }
            ?>
    </main>
</body>
</html>