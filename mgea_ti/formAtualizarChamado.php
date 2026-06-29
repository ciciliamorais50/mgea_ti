<?php
    include "header.php";
    include "conexaoBD.php";

    //Verifica se o usuário é administrador
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['nivelUsuario'] != 'administrador'){
        echo "
            <div class='container mt-5'>
                <div class='alert alert-secondary text-center'>Só admin pode mexer no status dos chamados.</div>
            </div>
        ";
        include "footer.php";
        exit;
    }

    //Verifica se o idChamado foi enviado pela URL
    if(isset($_GET['idChamado'])){
        $idChamado = intval($_GET['idChamado']);

        //QUERY para buscar o chamado pelo idChamado
        $buscarChamado = "
            SELECT c.*, u.nomeUsuario, ic.nomeItem AS categoria
            FROM chamados c
            INNER JOIN Usuarios u ON c.idUsuario = u.idUsuario
            INNER JOIN itens_categoria ic ON c.idItemCategoria = ic.idItemCategoria
            WHERE c.idChamado = $idChamado
        ";

        $res = mysqli_query($conn, $buscarChamado) or die("Erro ao tentar buscar o chamado!");

        if(mysqli_num_rows($res) > 0){
            $chamado = mysqli_fetch_assoc($res);

            $nomeUsuario       = $chamado['nomeUsuario'];
            $nomeEquipamento   = $chamado['nomeEquipamento'];
            $descricaoChamado  = $chamado['descricaoChamado'];
            $prioridadeChamado = $chamado['prioridadeChamado'];
            $statusChamado     = $chamado['statusChamado'];
        }
        else{
            echo "
                <div class='container mt-5'>
                    <div class='alert alert-secondary text-center'>Chamado não encontrado.</div>
                </div>
            ";
            include "footer.php";
            exit;
        }
    }
    else{
        echo "
            <div class='container mt-5'>
                <div class='alert alert-secondary text-center'>Nenhum chamado foi selecionado.</div>
            </div>
        ";
        include "footer.php";
        exit;
    }
?>

    <section class="py-5">
        <div class="d-flex justify-content-center mb-3">
            <div class="row">
                <div class="col">

                    <h2>Atualizar Chamado #<?php echo $idChamado; ?></h2>

                    <table class="table mt-3">
                        <tr><th>Solicitante</th><td><?php echo htmlspecialchars($nomeUsuario) ?></td></tr>
                        <tr><th>Equipamento</th><td><?php echo htmlspecialchars($nomeEquipamento) ?></td></tr>
                        <tr><th>Prioridade</th><td><?php echo htmlspecialchars($prioridadeChamado) ?></td></tr>
                        <tr><th>Descrição</th><td><?php echo htmlspecialchars($descricaoChamado) ?></td></tr>
                    </table>

                            <form action="actionAtualizarChamado.php" method="POST" class="was-validated">

                        <input type="hidden" name="idChamado" value="<?php echo $idChamado; ?>">

                        <div class="form-floating mt-3 mb-3">
                            <select class="form-select" id="statusChamado" name="statusChamado" required>
                                <option value="Aberto" <?php if($statusChamado == "Aberto") echo "selected"; ?>>Aberto</option>
                                <option value="Em andamento" <?php if($statusChamado == "Em andamento") echo "selected"; ?>>Em Andamento</option>
                                <option value="Resolvido" <?php if($statusChamado == "Resolvido") echo "selected"; ?>>Resolvido</option>
                                <option value="Fechado" <?php if($statusChamado == "Fechado") echo "selected"; ?>>Fechado</option>
                            </select>
                            <label for="statusChamado">Status do Chamado</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <button type="submit" class="btn btn-outline-dark">Salvar Alterações</button>
                    </form>

                </div>
            </div>
        </div>
    </section>

<?php include "footer.php" ?>
