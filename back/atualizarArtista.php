?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Registros</title>
    <link rel="stylesheet" href="../estilos/styleVerificar.css">
    <link href="https://fonts.googleapis.com/css2?family=Limelight&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alumni+Sans+Pinstripe:ital@0;1&display=swap" rel="stylesheet">
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
        <form action="atualizarArtista.php" method="get">
            <p>Atualize as informações das suas playlists ou do seu artista favorito.</p>
            <input type="text" placeholder="Ex: Gisem" name="artista" id="artista" required>
            <input type="submit" value="Buscar">
        </form>
    </section>

    <section>
        <?php
        if (isset($_GET["artista"])) {
            $artista = trim($_GET["artista"]);
            $pagina = isset($_GET["pagina"]) ? (int)$_GET["pagina"] : 1;
            $limite = 5;
            $offset = ($pagina - 1) * $limite;

            include("../conexao/conexao.php");

            $sql = "SELECT * FROM musicas WHERE artista LIKE ? LIMIT ? OFFSET ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $param_artista = "%$artista%";
                $stmt->bind_param("sii", $param_artista, $limite, $offset);
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows > 0) {
                    echo "<form action='processaCadastro.php' method='post'>";
                    echo "<div class='table-responsive'>";
                    echo "<table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Artista</th>
                                    <th>Nome da Música</th>
                                    <th>Álbum</th>
                                </tr>
                            </thead>
                            <tbody>";

                    while ($row = $resultado->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['artista']}</td>
                                <td><input type='text' name='nome[{$row['id']}]' value='{$row['nome']}' required></td>
                                <td><input type='text' name='album[{$row['id']}]' value='{$row['album']}' required></td>
                              </tr>";
                    }

                    echo "</tbody></table></div>";
                    echo "<input type='submit' value='Atualizar'>";
                    echo "</form>";

                    // Paginação
                    $sqlTotal = "SELECT COUNT(*) AS total FROM musicas WHERE artista LIKE ?";
                    $stmtTotal = $conn->prepare($sqlTotal);
                    $stmtTotal->bind_param("s", $param_artista);
                    $stmtTotal->execute();
                    $resTotal = $stmtTotal->get_result();
                    $total = $resTotal->fetch_assoc()['total'];
                    $totalPaginas = ceil($total / $limite);

                    if ($totalPaginas > 1) {
                        echo '<div class="paginacao">';
                        if ($pagina > 1) {
                            echo '<a href="?artista='.urlencode($artista).'&pagina='.($pagina - 1).'">Anterior</a>';
                        }
                        for ($i = 1; $i <= $totalPaginas; $i++) {
                            if ($i == $pagina) {
                                echo '<span class="atual">'.$i.'</span>';
                            } else {
                                echo '<a href="?artista='.urlencode($artista).'&pagina='.$i.'">'.$i.'</a>';
                            }
                        }
                        if ($pagina < $totalPaginas) {
                            echo '<a href="?artista='.urlencode($artista).'&pagina='.($pagina + 1).'">Próxima</a>';
                        }
                        echo '</div>';
                    }

                } else {
                    echo "<div class='mensagem erro'>Nenhuma música encontrada para '".htmlspecialchars($artista)."'</div>";
                }

                $stmt->close();
            } else {
                echo "<div class='mensagem erro'>Erro na preparação da consulta.</div>";
            }

            $conn->close();
        }
        ?>
    </section>
</main>

</body>
</html>