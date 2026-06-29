<?php include "header.php" ?>

    <div class="container mt-3 mb-3">

        <?php
            //Verifica se o usuário é administrador ou técnico de TI
            if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || ($_SESSION['nivelUsuario'] != 'administrador' && $_SESSION['nivelUsuario'] != 'ti')){
                echo "<div class='alert alert-secondary text-center'>Esse espaço é só pra TI e admins.</div>";
                include "footer.php";
                exit;
            }

            include "conexaoBD.php";

            //Verifica se há algum parâmetro chamado 'statusChamado' sendo recebido por GET
            $filtroChamado = $_GET['statusChamado'] ?? 'todos';

            if($filtroChamado == 'todos'){
                $listarChamados = "SELECT c.*, u.nomeUsuario, ic.nomeItem as categoria
                                    FROM chamados c
                                    INNER JOIN Usuarios u ON c.idUsuario = u.idUsuario
                                    INNER JOIN itens_categoria ic ON c.idItemCategoria = ic.idItemCategoria
                                    ORDER BY c.idChamado DESC";
            }
            else{
                $listarChamados = "SELECT c.*, u.nomeUsuario, ic.nomeItem as categoria
                                    FROM chamados c
                                    INNER JOIN Usuarios u ON c.idUsuario = u.idUsuario
                                    INNER JOIN itens_categoria ic ON c.idItemCategoria = ic.idItemCategoria
                                    WHERE c.statusChamado = '$filtroChamado'
                                    ORDER BY c.idChamado DESC";
            }

            $res = mysqli_query($conn, $listarChamados) or die("Erro ao tentar listar chamados: " . mysqli_error($conn));
            $totalChamados = mysqli_num_rows($res);
        ?>

        <h3 class="text-center mb-4">Gerenciar Chamados de TI</h3>

        <!-- Formulário para Filtrar os Chamados -->
        <form method="get" class="mb-4" action="listarChamados.php">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <select name="statusChamado" class="form-select">
                        <option value="todos" <?php if($filtroChamado == 'todos'){echo "selected";} ?>>Exibir todos os chamados</option>
                        <option value="Aberto" <?php if($filtroChamado == 'Aberto'){echo "selected";} ?>>Exibir apenas abertos</option>
                        <option value="Em andamento" <?php if($filtroChamado == 'Em andamento'){echo "selected";} ?>>Exibir apenas em andamento</option>
                        <option value="Resolvido" <?php if($filtroChamado == 'Resolvido'){echo "selected";} ?>>Exibir apenas resolvidos</option>
                        <option value="Fechado" <?php if($filtroChamado == 'Fechado'){echo "selected";} ?>>Exibir apenas fechados</option>
                    </select>
                    <button type="submit" class="btn btn-outline-dark mt-3" style="float:right"><i class="bi bi-funnel"></i> Filtrar</button>
                </div>
            </div>
        </form>

        <?php
            echo "<div class='alert alert-secondary text-center'>Achei <strong>$totalChamados</strong> chamados por aqui.</div>";

            echo "
                <table class='table table-hover align-middle'>
                    <thead class='table-dark'>
                        <tr>
                            <th>ID</th>
                            <th>SOLICITANTE</th>
                            <th>EQUIPAMENTO</th>
                            <th>PRIORIDADE</th>
                            <th>DESCRIÇÃO</th>
                            <th>DATA</th>
                            <th>STATUS</th>
                            <th>AÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
            ";

            while($chamado = mysqli_fetch_assoc($res)){
                $idChamado         = $chamado['idChamado'];
                $nomeUsuario       = $chamado['nomeUsuario'];
                $nomeEquipamento   = $chamado['nomeEquipamento'];
                $patrimonio        = $chamado['patrimonioEquipamento'];
                $prioridadeChamado = $chamado['prioridadeChamado'];
                $descricaoChamado  = $chamado['descricaoChamado'];
                $dataChamado       = date('d/m/Y', strtotime($chamado['dataChamado']));
                $statusChamado     = $chamado['statusChamado'];

                //Define a cor do badge de status
                if($statusChamado == 'Aberto'){
                    $badge = "<span class='badge bg-light text-dark border'>Aberto</span>";
                }
                else if($statusChamado == 'Em andamento'){
                    $badge = "<span class='badge bg-light text-dark border'>Em andamento</span>";
                }
                else if($statusChamado == 'Resolvido'){
                    $badge = "<span class='badge bg-light text-dark border'>Resolvido</span>";
                }
                else{
                    $badge = "<span class='badge bg-light text-dark border'>Fechado</span>";
                }

                echo "
                    <tr>
                        <td>$idChamado</td>
                        <td>$nomeUsuario</td>
                        <td>$nomeEquipamento ($patrimonio)</td>
                        <td>$prioridadeChamado</td>
                        <td>" . htmlspecialchars($descricaoChamado) . "</td>
                        <td>$dataChamado</td>
                        <td>$badge</td>
                        <td>
                            <a href='formAtualizarChamado.php?idChamado=$idChamado' title='Atualizar status'>
                                <i class='bi bi-pencil-square' style='font-size:24px'></i>
                            </a>
                        </td>
                    </tr>
                ";
            }

            echo "</tbody></table>";
            mysqli_close($conn);
        ?>

    </div>

<?php include "footer.php" ?>
