<?php include "header.php" ?>

    <div class="container mt-3 mb-3">

        <?php
            //Verifica se há sessão ativa
            if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
                header("location:formLogin.php");
                exit;
            }

            //Query para listar TODOS os equipamentos do usuário logado
            $listarEquipamentos = "SELECT * FROM Equipamentos WHERE Usuarios_idUsuario = " . $_SESSION['idUsuario'];

            include "conexaoBD.php";
            $res = mysqli_query($conn, $listarEquipamentos) or die("Erro ao tentar listar equipamentos!");
            $totalEquipamentos = mysqli_num_rows($res);

            if($totalEquipamentos > 0){
                if($totalEquipamentos == 1){
                    echo "<div class='alert alert-info text-center'>Você possui <strong>$totalEquipamentos</strong> equipamento sob sua responsabilidade!</div>";
                }
                else{
                    echo "<div class='alert alert-info text-center'>Você possui <strong>$totalEquipamentos</strong> equipamentos sob sua responsabilidade!</div>";
                }
            }
            else{
                echo "<div class='alert alert-info text-center'>Você ainda <strong>não possui</strong> equipamentos sob sua responsabilidade!</div>";
            }

            echo "
                <table class='table'>
                    <thead class='table-dark'>
                        <tr>
                            <th>ID</th>
                            <th>FOTO</th>
                            <th>NOME</th>
                            <th>PATRIMÔNIO</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";

                        while($registro = mysqli_fetch_assoc($res)){
                            $idEquipamento         = $registro['idEquipamento'];
                            $fotoEquipamento       = $registro['fotoEquipamento'];
                            $nomeEquipamento       = $registro['nomeEquipamento'];
                            $patrimonioEquipamento = $registro['patrimonioEquipamento'];
                            $statusEquipamento     = $registro['statusEquipamento'];

                            echo "
                                <tr>
                                    <td>$idEquipamento</td>
                                    <td><img src='$fotoEquipamento' title='Foto de $nomeEquipamento' style='width:100px'></td>
                                    <td>$nomeEquipamento</td>
                                    <td>$patrimonioEquipamento</td>
                                    <td>$statusEquipamento</td>
                                    <td>
                                        <a href='visualizarEquipamento.php?idEquipamento=$idEquipamento' title='Visualizar este equipamento'>
                                            <i class='bi bi-eye' style='font-size:24px'></i>
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

<?php include "footer.php" ?>
