<!DOCTYPE html>Add commentMore actions
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Nota</title>
    <link rel="stylesheet" href="../estilos/styleVerificar.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Início</a></li>
                <li><a href="cadastro.php">Cadastrar Usuário</a></li>
                <li><a href="verificarCadastro.php">Listas Usuários</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="containerSection">
            <form action="atualizarNota.php" method="post">
                <select name="curso" id="curso" class="estilo">
                    <option value="ads">Análise e Desenvolvimento de Sistemas</option>
                    <option value="engenharia_software">Engenharia de Software</option>
                    <option value="ciencias_computacao">Ciências da Computação</option>
                    <option value="sistemas_informacao">Sistema da Informação</option>
                </select>
                <input type="submit" value="Buscar">
            </form>
        </section>
        <section>

            <?php
                //Verificar se o $POST['CURSO'] está vazio
                if (isset($_POST['curso'])) {

                    //Chamar a conexão com o DB
                    include("../conexao/conexao.php");

                    //Salvar a informação do curso selecionado
                    $curso = $_POST['curso'];

                    //Consulta no SQL
                    $sql = "SELECT * FROM usuarios WHERE curso = ?";

                    //Preparar a consulta SQL junto da conexão
                    $stmt = $conn->prepare($sql);

                    //Verificar se a conexão foi feita com sucesso
                    if ($stmt) {
                        $stmt->bind_param("s", $curso);
                        $stmt->execute();
                        $resultado = $stmt->get_result();
                        
                        if ($resultado->num_rows > 0) {
                        echo "
                        <form action='processaNota.php' method='post' id='form-nota'>
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Sobrenome</th>
                                        <th>Nota Atividade</th>
                                        <th>Nota Prova</th>
                                    </tr>
                                </thead>
                                <tbody> ";
                                    while ($row = $resultado->fetch_assoc()){
                                    echo "
                                        <tr>
                                            <td>{$row['ID']}</td>
                                            <td>{$row['NOME']}</td>
                                            <td>{$row['SOBRENOME']}</td>
                                            <td>
                                                <input type='number' name='nota_atividade[{$row['ID']}]' required> 
                                            </td>
                                            <td>
                                                <input type='number' name='nota_prova[{$row['ID']}]' required> 
                                            </td>
                                        </tr> ";
                                    }
                            echo "
                                </tbody>
                            </table>
                            ";
                            echo "<input type='submit' value='Enviar'>
                            </form>";
                            } else {
                                echo "<div class='mensagem erro'>Curso $curso não possui registros</div>";
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

<!-- step é opcional no input -->