<?php include "header.php" ?>

    <!-- Seção para conteúdo da página -->
    <section class="py-5">

        <div class="d-flex justify-content-center mb-3">

            <div class="row">
                <div class="col">
                    
                    <h2>Cadastro de Usuário:</h2>

                    <form action="actionUsuario.php" method="POST" class="was-validated" enctype="multipart/form-data">

                        <div class="form-floating mt-3 mb-3">
                            <input type="file" class="form-control" id="fotoUsuario" placeholder="Foto" name="fotoUsuario" required>
                            <label for="fotoUsuario">Foto</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <input type="text" class="form-control" id="nomeUsuario" placeholder="Nome" name="nomeUsuario" required>
                            <label for="nomeUsuario">Nome Completo</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <input type="date" class="form-control" id="dataNascimentoUsuario" placeholder="dataNascimentoUsuario" name="dataNascimentoUsuario" required>
                            <label for="dataNascimentoUsuario">Data de Nascimento</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <select class="form-select" id="setorUsuario" name="setorUsuario" placeholder="Setor" required>
                                <option value="TI">TI</option>
                                <option value="Administrativo">Administrativo</option>
                                <option value="Financeiro">Financeiro</option>
                                <option value="Manutenção">Manutenção</option>
                                <option value="Produção" selected>Produção</option>
                                <option value="Recursos Humanos">Recursos Humanos</option>
                            </select>
                            <label for="setorUsuario">Setor</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating mt-3 mb-3">
                            <input type="email" class="form-control" id="emailUsuario" placeholder="Email" name="emailUsuario" required>
                            <label for="emailUsuario">Email</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-floating mt-3 mb-3">
                            <input type="password" class="form-control" id="senhaUsuario" placeholder="Senha" name="senhaUsuario" required>
                            <label for="senhaUsuario">Senha</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-floating mt-3 mb-3">
                            <input type="password" class="form-control" id="confirmarSenhaUsuario" placeholder="Confirmar Senha" name="confirmarSenhaUsuario" required>
                            <label for="confirmarSenhaUsuario">Confirmar Senha</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>

                </div>
            </div>

        </div>

    </section>

<?php include "footer.php" ?>
