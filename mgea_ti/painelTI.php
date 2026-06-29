<?php include "header.php" ?>

    <div class="container mt-3 mb-3">

        <?php
            // Permite acesso somente a TI ou administradores
            if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || ($_SESSION['nivelUsuario'] != 'ti' && $_SESSION['nivelUsuario'] != 'administrador')){
                echo "<div class='alert alert-secondary text-center'>Só TI e admin podem chegar aqui.</div>";
                include "footer.php";
                exit;
            }

            include "conexaoBD.php";

            $sql = "SELECT c.idChamado, u.nomeUsuario, ic.nomeItem AS categoria, c.sistemaRelacionado, c.prioridade, c.descricaoProblema, c.dataAbertura, c.statusChamado
                    FROM chamados c
                    INNER JOIN Usuarios u ON c.idUsuario = u.idUsuario
                    INNER JOIN itens_categoria ic ON c.idItemCategoria = ic.idItemCategoria
                    WHERE c.statusChamado = 'Aberto'
                    ORDER BY c.dataAbertura DESC, c.idChamado DESC";

            $res = mysqli_query($conn, $sql) or die("Erro ao buscar chamados: " . mysqli_error($conn));
            $total = mysqli_num_rows($res);
        ?>

        <h3 class="text-center mb-4">Painel TI — Chamados Abertos (<?php echo $total; ?>)</h3>

        <?php
            if($total == 0){
                echo "<div class='alert alert-secondary text-center'>Nenhum chamado aberto agora, tá de boa.</div>";
            }
            else{
                echo "<table class='table table-hover align-middle'>
                        <thead class='table-dark'>
                            <tr>
                                <th>ID</th>
                                <th>Solicitante</th>
                                <th>Categoria</th>
                                <th>Sistema</th>
                                <th>Prioridade</th>
                                <th>Descrição</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>";

                while($row = mysqli_fetch_assoc($res)){
                    $id = $row['idChamado'];
                    $solicitante = htmlspecialchars($row['nomeUsuario']);
                    $categoria = htmlspecialchars($row['categoria']);
                    $sistema = htmlspecialchars($row['sistemaRelacionado']);
                    $prioridade = htmlspecialchars($row['prioridade']);
                    $descricao = htmlspecialchars($row['descricaoProblema']);
                    $data = date('d/m/Y', strtotime($row['dataAbertura']));

                    echo "<tr>
                            <td>$id</td>
                            <td>$solicitante</td>
                            <td>$categoria</td>
                            <td>$sistema</td>
                            <td>$prioridade</td>
                            <td>" . (strlen($descricao) > 120 ? substr($descricao,0,120) . '...' : $descricao) . "</td>
                            <td>$data</td>
                        </tr>";
                }

                echo "</tbody></table>";
            }

            mysqli_close($conn);
        ?>

        <div class="mt-3">
            <a href="listarChamados.php" class="btn btn-outline-primary">Ver todos os chamados</a>
        </div>

    </div>

<?php include "footer.php" ?>
