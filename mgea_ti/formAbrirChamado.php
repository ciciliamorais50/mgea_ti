<?php include "header.php" ?>

<?php
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
        echo "<div class='container mt-5'><div class='alert alert-secondary text-center'>Faz login pra poder abrir um chamado.</div></div>";
        include "footer.php";
        exit;
    }

    include "conexaoBD.php";
    $listarItens = "SELECT * FROM itens_categoria ORDER BY nomeItem";
    $resItens = mysqli_query($conn, $listarItens);
?>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-4">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-3">Abrir Chamado</h2>
                <p class="text-muted">Fala aí qual é o problema e o time de TI cuida do resto.</p>

                <?php
                    if(isset($_SESSION['erroChamado'])){
                        echo "<div class='alert alert-secondary'>" . htmlspecialchars($_SESSION['erroChamado']) . "</div>";
                        unset($_SESSION['erroChamado']);
                    }
                    if(isset($_SESSION['sucessoChamado'])){
                        echo "<div class='alert alert-secondary'>" . htmlspecialchars($_SESSION['sucessoChamado']) . "</div>";
                        unset($_SESSION['sucessoChamado']);
                    }
                ?>

                <form action="actionChamado.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Categoria do problema</label>
                            <select class="form-select" name="idItemCategoria" required>
                                <option value="">Selecione</option>
                                <?php while($item = mysqli_fetch_assoc($resItens)){ ?>
                                    <option value="<?php echo $item['idItemCategoria']; ?>"><?php echo htmlspecialchars($item['nomeItem']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sistema relacionado</label>
                            <select class="form-select" name="sistemaRelacionado" required>
                                <option value="SAP">SAP</option>
                                <option value="Pacote Office">Pacote Office</option>
                                <option value="AutoCAD">AutoCAD</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descrição do problema</label>
                            <textarea class="form-control" name="descricaoProblema" rows="4" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Prioridade</label>
                            <select class="form-select" name="prioridade" required>
                                <option value="Baixa">Baixa</option>
                                <option value="Média">Média</option>
                                <option value="Alta">Alta</option>
                                <option value="Urgente">Urgente</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Data de abertura</label>
                            <input type="date" class="form-control" name="dataAbertura" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="statusChamado" required>
                                <option value="Aberto">Aberto</option>
                                <option value="Em andamento">Em andamento</option>
                                <option value="Resolvido">Resolvido</option>
                                <option value="Fechado">Fechado</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['idUsuario']; ?>">

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Enviar chamado</button>
                        <a href="index.php" class="btn btn-outline-secondary">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php" ?>
