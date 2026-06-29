<?php include "header.php" ?>

<section class="py-5">

    <div class="d-flex justify-content mt-3 mb-3">

        <div class="row">
            <div class="col">

                <?php
                    //Verifica se o usuário é administrador
                    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['nivelUsuario'] != 'administrador'){
                        echo "<div class='alert alert-danger text-center'>Apenas administradores podem gerenciar equipamentos!</div>";
                        include "footer.php";
                        exit;
                    }

                    echo "<h3 class='text-center'>Gerenciar Equipamentos</h3>";

                    //Query para listar TODOS os registros da tabela Equipamentos
                    $listarEquipamentos = "
                        SELECT Equipamentos.*, Usuarios.nomeUsuario
                        FROM Equipamentos
                        INNER JOIN Usuarios ON Equipamentos.Usuarios_idUsuario = Usuarios.idUsuario
                        ORDER BY Equipamentos.idEquipamento DESC
                    ";

                    include "conexaoBD.php";
                    $res = mysqli_query($conn, $listarEquipamentos) or die("Erro ao tentar listar Equipamentos!");
                    $totalEquipamentos = mysqli_num_rows($res);

                    echo "<div class='alert alert-info text-center'>Há <strong>$totalEquipamentos</strong> equipamentos cadastrados no sistema!</div>";

                    echo "
                        <table class='table table-hover align-middle'>
                            <thead class='table-dark'>
                                <tr>
                                    <th>ID</th>
                                    <th>FOTO</th>
                                    <th>NOME</th>
                                    <th>PATRIMÔNIO</th>
                                    <th>RESPONSÁVEL</th>
                                    <th>STATUS</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                    ";

                    while($registro = mysqli_fetch_assoc($res)){
                        $idEquipamento         = $registro['idEquipamento'];
                        $fotoEquipamento       = $registro['fotoEquipamento'];
                        $nomeEquipamento       = $registro['nomeEquipamento'];
                        $patrimonioEquipamento = $registro['patrimonioEquipamento'];
                        $nomeUsuario           = $registro['nomeUsuario'];
                        $statusEquipamento     = $registro['statusEquipamento'];

                        echo "
                            <tr>
                                <td>$idEquipamento</td>
                                <td><img src='$fotoEquipamento' title='Foto de $nomeEquipamento' style='width:80px'></td>
                                <td>$nomeEquipamento</td>
                                <td>$patrimonioEquipamento</td>
                                <td>$nomeUsuario</td>
                                <td>$statusEquipamento</td>
                                <td>
                                    <a href='visualizarEquipamento.php?idEquipamento=$idEquipamento' title='Visualizar'>
                                        <i class='bi bi-eye' style='font-size:22px'></i>
                                    </a>
                                    &nbsp;
                                    <a href='formEditarEquipamento.php?idEquipamento=$idEquipamento' title='Editar'>
                                        <i class='bi bi-pencil-square' style='font-size:22px'></i>
                                    </a>
                                    &nbsp;
                                    <a href='actionExcluirEquipamento.php?idEquipamento=$idEquipamento' title='Excluir' onclick=\"return confirm('Tem certeza que deseja excluir este equipamento?')\">
                                        <i class='bi bi-trash' style='font-size:22px; color:#dc3545'></i>
                                    </a>
                                </td>
                            </tr>
                        ";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    mysqli_close($conn);
                ?>

            </div>
        </div>

    </div>

</section>

<?php include "footer.php" ?>
