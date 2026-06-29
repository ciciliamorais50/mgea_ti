<?php include "header.php" ?>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--azul-escuro);">TechDesk</h2>
            <p class="text-muted">Escolha uma das opções abaixo para continuar.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <a href="formAbrirChamado.php" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center" style="border-radius: 14px;">
                        <i class="bi bi-tools display-4 mb-3" style="color: var(--azul-medio);"></i>
                        <h4 class="fw-bold">Abrir Chamado</h4>
                        <p class="text-muted mb-0">Registre problemas de sistema, rede, hardware ou software.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="formItens.php" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center" style="border-radius: 14px;">
                        <i class="bi bi-list-check display-4 mb-3" style="color: var(--azul-medio);"></i>
                        <h4 class="fw-bold">Incluir Itens</h4>
                        <p class="text-muted mb-0">Cadastre categorias e tipos de chamado para usar na abertura de solicitações.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="formSolicitarTroca.php" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center" style="border-radius: 14px;">
                        <i class="bi bi-arrow-repeat display-4 mb-3" style="color: var(--azul-medio);"></i>
                        <h4 class="fw-bold">Solicitar Troca por Perda</h4>
                        <p class="text-muted mb-0">Solicite a substituição de um equipamento perdido com os dados necessários.</p>
                    </div>
                </a>
            </div>
        </div>

        <?php if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){ ?>
            <div class="text-center mt-4">
                <a href="formLogin.php" class="btn btn-primary">Entrar para continuar</a>
            </div>
        <?php } ?>
    </div>
</section>

<?php include "footer.php" ?>