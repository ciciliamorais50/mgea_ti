<?php include "header.php" ?>

<?php
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
        echo "<div class='container mt-5'><div class='alert alert-secondary text-center'>Faz login pra poder incluir itens.</div></div>";
        include "footer.php";
        exit;
    }
?>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-4">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-3">Incluir Itens</h2>
                <p class="text-muted">Cadastre categorias ou tipos de chamado que poderão ser usados na abertura de solicitações.</p>

                <form action="actionItens.php" method="POST">
                    <div id="itensContainer">
                        <div class="border rounded p-3 mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control" name="itens[0][nomeItem]" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Data</label>
                                    <input type="date" class="form-control" name="itens[0][dataCadastro]" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Descrição</label>
                                    <textarea class="form-control" name="itens[0][descricaoItem]"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Número de Série</label>
                                    <input type="text" class="form-control" name="itens[0][numeroSerie]">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Conta Office</label>
                                    <input type="text" class="form-control" name="itens[0][contaOffice]">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary mb-3" id="adicionarItem">+ Adicionar Item</button>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Salvar Itens</button>
                        <a href="index.php" class="btn btn-outline-secondary">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
let contador = 1;
document.getElementById('adicionarItem').addEventListener('click', function () {
    const container = document.getElementById('itensContainer');
    const html = `
        <div class="border rounded p-3 mb-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" name="itens[${contador}][nomeItem]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Data</label>
                    <input type="date" class="form-control" name="itens[${contador}][dataCadastro]" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Descrição</label>
                    <textarea class="form-control" name="itens[${contador}][descricaoItem]"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Número de Série</label>
                    <input type="text" class="form-control" name="itens[${contador}][numeroSerie]">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Conta Office</label>
                    <input type="text" class="form-control" name="itens[${contador}][contaOffice]">
                </div>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
    contador++;
});
</script>

<?php include "footer.php" ?>
