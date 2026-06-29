<?php include "header.php" ?>

<?php
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
        echo "<div class='container mt-5'><div class='alert alert-secondary text-center'>Faz login pra continuar.</div></div>";
        include "footer.php";
        exit;
    }

    if($_SESSION['nivelUsuario'] != 'ti' && $_SESSION['nivelUsuario'] != 'administrador'){
        echo "<div class='container mt-5'><div class='alert alert-secondary text-center'>Só TI e admins podem ver essa página.</div></div>";
        include "footer.php";
        exit;
    }

    if(!isset($_GET['idUsuario']) || !is_numeric($_GET['idUsuario'])){
        echo "<div class='container mt-5'><div class='alert alert-secondary text-center'>Usuário inválido, volta lá e tenta de novo.</div></div>";
        include "footer.php";
        exit;
    }

    $idUsuario = intval($_GET['idUsuario']);
    include "conexaoBD.php";

    $userSql = "SELECT idUsuario, nomeUsuario, emailUsuario FROM Usuarios WHERE idUsuario = $idUsuario";
    $userRes = mysqli_query($conn, $userSql) or die('Erro ao buscar usuário: ' . mysqli_error($conn));

    if(mysqli_num_rows($userRes) === 0){
        echo "<div class='container mt-5'><div class='alert alert-secondary text-center'>Não achei esse usuário, vê se está certo o ID.</div></div>";
        include "footer.php";
        exit;
    }

    $user = mysqli_fetch_assoc($userRes);
    $listarEquipamentos = "SELECT * FROM Equipamentos WHERE Usuarios_idUsuario = $idUsuario ORDER BY idEquipamento DESC";
    $equipRes = mysqli_query($conn, $listarEquipamentos) or die('Erro ao listar equipamentos: ' . mysqli_error($conn));
    $totalEquipamentos = mysqli_num_rows($equipRes);
?>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-4">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-3">Equipamentos de <?php echo htmlspecialchars($user['nomeUsuario']); ?></h2>
                <p class="text-muted">Total de equipamentos: <?php echo $totalEquipamentos; ?></p>

                <?php
                    if($totalEquipamentos === 0){
                        echo "<div class='alert alert-secondary'>Esse usuário ainda não tem equipamento registrado.</div>";
                    } else {
                        echo "<table class='table table-hover align-middle'>
                                <thead class='table-dark'>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Patrimônio</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>";

                        while($registro = mysqli_fetch_assoc($equipRes)){
                            $idEquipamento = $registro['idEquipamento'];
                            $nomeEquipamento = htmlspecialchars($registro['nomeEquipamento']);
                            $patrimonio = htmlspecialchars($registro['patrimonioEquipamento']);
                            $status = htmlspecialchars($registro['statusEquipamento']);
                            $data = date('d/m/Y', strtotime($registro['dataEquipamento']));

                            echo "<tr>
                                    <td>$idEquipamento</td>
                                    <td>$nomeEquipamento</td>
                                    <td>$patrimonio</td>
                                    <td>$status</td>
                                    <td>$data</td>
                                    <td><a href='visualizarEquipamento.php?idEquipamento=$idEquipamento' class='btn btn-sm btn-outline-secondary'>Ver</a></td>
                                  </tr>";
                        }

                        echo "</tbody></table>";
                    }
                ?>

                <div class="mt-3">
                    <a href="listaEquipamentosPorUsuario.php" class="btn btn-outline-secondary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php" ?>
