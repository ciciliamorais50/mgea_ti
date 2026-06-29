<?php include "header.php" ?>

    <?php
        //Verifica se o usuário está logado
        if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
            echo "
                <div class='container mt-5'>
                    <div class='alert alert-danger text-center'>Faça login para cadastrar equipamentos.</div>
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
                    
                    <h2>Cadastro de Equipamento:</h2>
                    <div class="alert alert-secondary">
                        Conta aqui qual equipamento está com você, número de série e conta Office.
                    </div>

                    <form action="actionEquipamento.php" method="POST" class="was-validated" enctype="multipart/form-data">

                        <div class="form-floating mt-3 mb-3">
                            <input type="file" class="form-control" id="fotoEquipamento" placeholder="Foto" name="fotoEquipamento">
                            <label for="fotoEquipamento">Foto do Equipamento</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <input type="text" class="form-control" id="nomeEquipamento" placeholder="Nome do Equipamento" name="nomeEquipamento">
                            <label for="nomeEquipamento">Nome do Equipamento</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <select class="form-select" id="tipoEquipamento" name="tipoEquipamento" placeholder="Selecione um Tipo">
                                <option value="Notebook">Notebook</option>
                                <option value="Desktop">Desktop</option>
                                <option value="Monitor">Monitor</option>
                                <option value="Impressora">Impressora</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Servidor">Servidor</option>
                                <option value="SAP">SAP</option>
                                <option value="PACOTE OFFICE">PACOTE OFFICE</option>
                                <option value="AUTOCAD">AUTOCAD</option>
                                <option value="Outros" selected>Outros</option>
                            </select>
                            <label for="tipoEquipamento">Tipo do Equipamento</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <input type="text" class="form-control" id="patrimonioEquipamento" placeholder="Patrimônio" name="patrimonioEquipamento">
                            <label for="patrimonioEquipamento">Número de Patrimônio</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <input type="text" class="form-control" id="numeroSerieEquipamento" placeholder="Número de Série" name="numeroSerieEquipamento" required>
                            <label for="numeroSerieEquipamento">Número de Série</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <input type="text" class="form-control" id="contaOfficeEquipamento" placeholder="Conta Office" name="contaOfficeEquipamento" required>
                            <label for="contaOfficeEquipamento">Conta Office em uso</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <?php if($_SESSION['nivelUsuario'] == 'administrador'){ ?>
                            <div class="form-floating mt-3 mb-3">
                                <select class="form-select" id="Usuarios_idUsuario" name="Usuarios_idUsuario" placeholder="Responsável">
                                    <?php
                                        include "conexaoBD.php";
                                        $listarUsuarios = "SELECT * FROM Usuarios ORDER BY nomeUsuario";
                                        $resUsuarios = mysqli_query($conn, $listarUsuarios);
                                        while($usu = mysqli_fetch_assoc($resUsuarios)){
                                            echo "<option value='{$usu['idUsuario']}'>{$usu['nomeUsuario']}</option>";
                                        }
                                    ?>
                                </select>
                                <label for="Usuarios_idUsuario">Usuário Responsável</label>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback"></div>
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="Usuarios_idUsuario" value="<?php echo $_SESSION['idUsuario']; ?>">
                            <div class="alert alert-secondary">Este cadastro será vinculado ao seu usuário.</div>
                        <?php } ?>

                        <div class="form-floating mt-3 mb-3">
                            <textarea class="form-control" id="descricaoEquipamento" 
                            placeholder="Informe uma breve descrição sobre o equipamento" name="descricaoEquipamento"></textarea>
                            <label for="descricaoEquipamento">Descrição do Equipamento</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Cadastrar Equipamento</button>
                    </form>

                </div>
            </div>

        </div>

    </section>

<?php include "footer.php" ?>
