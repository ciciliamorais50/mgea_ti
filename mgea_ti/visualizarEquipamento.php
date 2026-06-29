<?php

    include "header.php";
    include "conexaoBD.php";

    if(isset($_GET['idEquipamento'])){
        $idEquipamento = $_GET['idEquipamento'];

        //QUERY para buscar o equipamento e o nome do usuário responsável
        $buscarEquipamento = "SELECT equipamentos.*, usuarios.nomeUsuario
                          FROM equipamentos
                          INNER JOIN usuarios
                            ON equipamentos.Usuarios_idUsuario = usuarios.idUsuario
                          WHERE equipamentos.idEquipamento = $idEquipamento
                          ";

        //Executa a QUERY
        $resEquipamento = mysqli_query($conn, $buscarEquipamento);

        //Verifica se encontrou o equipamento
        if(mysqli_num_rows($resEquipamento) > 0){
            //Converte o resultado em array associativo
            $equipamento = mysqli_fetch_assoc($resEquipamento);

            $idEquipamento         = $equipamento['idEquipamento'];
            $fotoEquipamento       = $equipamento['fotoEquipamento'];
            $nomeEquipamento       = $equipamento['nomeEquipamento'];
            $tipoEquipamento       = $equipamento['tipoEquipamento'];
            $patrimonioEquipamento = $equipamento['patrimonioEquipamento'];
            $descricaoEquipamento  = $equipamento['descricaoEquipamento'];
            $dataEquipamento       = $equipamento['dataEquipamento'];
            $statusEquipamento     = $equipamento['statusEquipamento'];
        }
        else{
            echo "<div class='alert alert-danger text-center'>Equipamento não encontrado!</div>";
            include "footer.php";
            exit();
        }
                
    }
    else{
        echo "<div class='alert alert-danger text-center'>ID do Equipamento não informado!</div>";
        include "footer.php";
        exit();
    }

?>

<style>
    .img-produto-principal {
        width: 100%;
        max-height: 600px;
        object-fit: contain;
    }
</style>

<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <img class="img-produto-principal mb-5 mb-md-0 <?php if($statusEquipamento == 'baixado'){ echo 'imagem-baixada'; } ?>"
                     src="<?php echo htmlspecialchars($fotoEquipamento); ?>"
                     alt="<?php echo htmlspecialchars($nomeEquipamento); ?>"
                     title="<?php echo htmlspecialchars($nomeEquipamento); ?>"
                />
            </div>
            <div class="col-md-6">
                <div class="small mb-1">
                    Tipo: <?php echo htmlspecialchars($tipoEquipamento) ?>
                </div>
                <h1 class="display-5 fw-bolder">
                    <?php echo htmlspecialchars($nomeEquipamento) ?>
                </h1>
                <div class="fs-5 mb-3">
                    Patrimônio: <strong><?php echo htmlspecialchars($patrimonioEquipamento); ?></strong>
                </div>
                <p class="lead">
                    <?php echo htmlspecialchars($descricaoEquipamento); ?>
                </p>
                <p class="text-muted">
                    Responsável: <strong><?php echo htmlspecialchars($equipamento['nomeUsuario']); ?></strong><br>
                    Cadastrado em <?php echo date('d/m/Y', strtotime($dataEquipamento)); ?>
                </p>
                <p>
                    Status:
                    <?php
                        if($statusEquipamento == 'ativo'){
                            echo "<span class='badge bg-success'>Ativo</span>";
                        }
                        else if($statusEquipamento == 'manutencao'){
                            echo "<span class='badge bg-warning text-dark'>Em Manutenção</span>";
                        }
                        else{
                            echo "<span class='badge bg-danger'>Baixado</span>";
                        }
                    ?>
                </p>

                <?php
                    if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){ //Verifica se há sessão ativa

                        echo "
                            <a href='formAbrirChamado.php?idEquipamento=$idEquipamento' class='btn btn-outline-dark btn-lg mt-3'>
                                <i class='bi bi-life-preserver me-1'></i>
                                Abrir Chamado para este Equipamento
                            </a>
                        ";

                        if($_SESSION['nivelUsuario'] == 'administrador'){
                            echo "
                                <a href='formEditarEquipamento.php?idEquipamento=$idEquipamento' class='btn btn-outline-secondary btn-lg mt-3'>
                                    <i class='bi bi-gear me-1'></i>
                                    Editar Equipamento
                                </a>
                            ";
                        }
                    }
                    else{
                        echo "
                            <a href='formLogin.php' class='btn btn-outline-dark btn-lg mt-3'>
                                <i class='bi bi-person me-1'></i>
                                Acesse o sistema para abrir um chamado
                            </a>
                        ";
                    }
                ?>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php" ?>
