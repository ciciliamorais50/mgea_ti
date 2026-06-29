<?php include "header.php" ?>

<?php
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
        echo "<div class='container mt-5'><div class='alert alert-secondary text-center'>Faz login pra solicitar troca por perda.</div></div>";
        include "footer.php";
        exit;
    }
?>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-4">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-3">Solicitar Troca por Perda</h2>
                <p class="text-muted">Informe os dados do equipamento perdido para abertura da solicitação.</p>

                <form action="actionTroca.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nome do equipamento</label>
                            <input type="text" class="form-control" name="nomeEquipamento" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Número de Série</label>
                            <input type="text" class="form-control" name="numeroSerie">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Conta Office</label>
                            <input type="text" class="form-control" name="contaOffice">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Data da ocorrência</label>
                            <input type="date" class="form-control" name="dataOcorrencia" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Motivo da perda</label>
                            <textarea class="form-control" name="motivoPerda" rows="4" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Solicitante</label>
                            <input type="text" class="form-control" name="solicitante" value="<?php echo htmlspecialchars($_SESSION['nomeUsuario']); ?>" required>
                        </div>
                    </div>

                    <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['idUsuario']; ?>">

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
                        <a href="index.php" class="btn btn-outline-secondary">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php" ?>
