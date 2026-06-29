<?php 
    include "header.php";
    include "conexaoBD.php";

    //Verifica se o usuário é administrador
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['nivelUsuario'] != 'administrador'){
        echo "
            <div class='container mt-5'>
                <div class='alert alert-secondary text-center'>Só admin pode editar equipas.</div>
            </div>
        ";
        include "footer.php";
        exit;
    }

    //Verifica se o idEquipamento foi enviado pela URL
    if(isset($_GET['idEquipamento'])){
        $idEquipamento = $_GET['idEquipamento'];

        //QUERY para buscar o equipamento pelo idEquipamento
        $buscarEquipamento = "
            SELECT *
            FROM Equipamentos
            WHERE idEquipamento = $idEquipamento
        ";

        //Executar a QUERY
        $res = mysqli_query($conn, $buscarEquipamento) or die("Erro ao tentar buscar o equipamento!");

        //Verifica se encontrou algum equipamento com o id informado
        if(mysqli_num_rows($res) > 0){
            $equipamento = mysqli_fetch_assoc($res); //Cria um array associativo para armazenar dados do equipamento

            $fotoEquipamento       = $equipamento['fotoEquipamento'];
            $nomeEquipamento       = $equipamento['nomeEquipamento'];
            $tipoEquipamento       = $equipamento['tipoEquipamento'];
            $patrimonioEquipamento = $equipamento['patrimonioEquipamento'];
            $descricaoEquipamento  = $equipamento['descricaoEquipamento'];
            $statusEquipamento     = $equipamento['statusEquipamento'];
            $idUsuarioAtual        = $equipamento['Usuarios_idUsuario'];
        }
        else{
            echo "
                <div class='container mt-5'>
                    <div class='alert alert-secondary text-center'>Equipamento não encontrado.</div>
                </div>
            ";
            include "footer.php";
            exit;
        }
    }
    else{
        echo "
            <div class='container mt-5'>
                <div class='alert alert-secondary text-center'>Nenhum equipamento foi selecionado.</div>
            </div>
        ";
        include "footer.php";
        exit;
    }
    
?>

    <!-- Seção para conteúdo da página -->
    <section class="py-5">

        <div class="d-flex justify-content-center mb-3">

            <div class="row">
                <div class="col">
                    
                    <h2>Editar Equipamento:</h2>

                    <form action="actionEditarEquipamento.php" method="POST" class="was-validated" enctype="multipart/form-data">

                        <input type="hidden" name="idEquipamento" value="<?php echo $idEquipamento; ?>">
                        <input type="hidden" name="fotoAtual" value="<?php echo $fotoEquipamento; ?>">

                        <div class="form-floating mt-3 mb-3">
                            <?php
                                if(!empty($fotoEquipamento)){
                                    echo "
                                        <div class='mb-3 text-center'>
                                            <img src='$fotoEquipamento' class='img-thumbnail' style='max-width: 200px;'>
                                            <p class='mt-2'>Foto atual do Equipamento</p>
                                        </div>
                                    ";
                                }
                            ?>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <input type="file" class="form-control" id="fotoEquipamento" placeholder="Foto" name="fotoEquipamento">
                            <label for="fotoEquipamento">Nova foto do Equipamento</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <input type="text" class="form-control" id="nomeEquipamento" placeholder="Nome do Equipamento" name="nomeEquipamento" value="<?php echo $nomeEquipamento ?>" required>
                            <label for="nomeEquipamento">Nome do Equipamento</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <select class="form-select" id="tipoEquipamento" name="tipoEquipamento" required>
                                <option value="Notebook" <?php if($tipoEquipamento == "Notebook") echo "selected"; ?>>Notebook</option>
                                <option value="Desktop" <?php if($tipoEquipamento == "Desktop") echo "selected"; ?>>Desktop</option>
                                <option value="Monitor" <?php if($tipoEquipamento == "Monitor") echo "selected"; ?>>Monitor</option>
                                <option value="Impressora" <?php if($tipoEquipamento == "Impressora") echo "selected"; ?>>Impressora</option>
                                <option value="Tablet" <?php if($tipoEquipamento == "Tablet") echo "selected"; ?>>Tablet</option>
                                <option value="Servidor" <?php if($tipoEquipamento == "Servidor") echo "selected"; ?>>Servidor</option>
                                <option value="Outro" <?php if($tipoEquipamento == "Outro") echo "selected"; ?>>Outro</option>
                            </select>
                            <label for="tipoEquipamento">Tipo do Equipamento</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <input type="text" class="form-control" id="patrimonioEquipamento" placeholder="Patrimônio" name="patrimonioEquipamento" value="<?php echo $patrimonioEquipamento ?>" required>
                            <label for="patrimonioEquipamento">Número de Patrimônio</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <select class="form-select" id="Usuarios_idUsuario" name="Usuarios_idUsuario" required>
                                <?php
                                    $listarUsuarios = "SELECT * FROM Usuarios ORDER BY nomeUsuario";
                                    $resUsuarios = mysqli_query($conn, $listarUsuarios);
                                    while($usu = mysqli_fetch_assoc($resUsuarios)){
                                        $sel = ($usu['idUsuario'] == $idUsuarioAtual) ? "selected" : "";
                                        echo "<option value='{$usu['idUsuario']}' $sel>{$usu['nomeUsuario']}</option>";
                                    }
                                ?>
                            </select>
                            <label for="Usuarios_idUsuario">Usuário Responsável</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <textarea class="form-control" id="descricaoEquipamento" name="descricaoEquipamento" required><?php echo $descricaoEquipamento ?></textarea>
                            <label for="descricaoEquipamento">Descrição do Equipamento</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <select class="form-select" id="statusEquipamento" name="statusEquipamento" required>
                                <option value="ativo" <?php if($statusEquipamento == "ativo") echo "selected"; ?>>Ativo</option>
                                <option value="manutencao" <?php if($statusEquipamento == "manutencao") echo "selected"; ?>>Em Manutenção</option>
                                <option value="baixado" <?php if($statusEquipamento == "baixado") echo "selected"; ?>>Baixado</option>
                            </select>
                            <label for="statusEquipamento">Status do Equipamento</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>

                </div>
            </div>

        </div>

    </section>

<?php include "footer.php" ?>
