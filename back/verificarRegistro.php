<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Registros</title>
    <link rel="stylesheet" href="../estilos/styleVerificar.css">
    <link href="https://fonts.googleapis.com/css2?family=Limelight&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alumni+Sans+Pinstripe:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Combo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Combo&display=swap" rel="stylesheet">
    
</head>
<body>
<header>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="cadastro.php">Registrar Músicas</a></li>
                <li><a href="verificarRegistro.php">Verificar Playlists</a></li>
                <li><a href="atualizarArtista.php">Atualizar Playlists</a></li>
                <li><a href="verificarGenero.php">Consulta por gênero</a></li>
            </ul>
            </ul>
        </nav>
    </header>
    
    <main>
        
        <section id="containerSection">
            
        <section id="containerSection">
            <form action="verificarRegistro.php" method="post">
                <p>Consulte as informações pelo seu artista favorito. <br>Informe o nome do artista</p>
                <input type="text" placeholder="Informe o artista" name="artista" id="artista">
                <input type="submit" value="Buscar">
            </form>
        </section>
        <section>

            <?php
                
                //Verificar se o campo artista está preenchido

                if(isset($_POST["artista"])) { 
                    //Salva as informações enviados pelo form
                    $artista = $_POST["artista"];
                    
                    //Receba as informações de conexão com o DB
                    include("../conexao/conexao.php");

                    //Query ao banco de dados
                    $sql = "SELECT * FROM musicas WHERE artista = ?";
                    //Preparar a conexão junto com a consulta
                    $stmt = $conn->prepare($sql);
                    
                    //Validando se a conexão foi feita com sucesso
                    if($stmt){
                        //Troca a informação por ? (previne hack/roubo)
                        $stmt->bind_param("s", $artista);
                        //Executa o comando
                        $stmt->execute();
                        //Salva o resultado da consulta
                        $resultado = $stmt->get_result();
                        // echo var_dump($resultado);
                        
                        if ($resultado->num_rows > 0) {
                            //Armazenar as informações vindas do DB
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
                                </table>
        
                                ";
                    }else {
                        echo "<div class='mensagem erro'> Artista $artista não encontrado </div>";
                        }
                    //Encerra consulta do SQL
                    $stmt->close();
                }else {
                echo "<div class='mensagem erro'>Erro na consulta </div>";
                }
            //Encerra a conexão com o banco de dados
            $conn->close();
        }
            ?>

        </section>
    </main>

</body>
</html>