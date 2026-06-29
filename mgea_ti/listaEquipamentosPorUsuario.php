<?php include "header.php" ?>

<?php
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
        echo "<div class='container mt-5'><div class='alert alert-danger text-center'>Faça login para acessar esta página.</div></div>";
        include "footer.php";
        exit;
    }

    if($_SESSION['nivelUsuario'] != 'ti' && $_SESSION['nivelUsuario'] != 'administrador'){
        echo "<div class='container mt-5'><div class='alert alert-danger text-center'>Apenas técnicos TI e administradores podem acessar esta lista.</div></div>";
        include "footer.php";
        exit;
    }

    include "conexaoBD.php";
    $sql = "SELECT u.idUsuario, u.nomeUsuario, u.emailUsuario, u.setorUsuario, u.nivelUsuario,
                   COUNT(e.idEquipamento) AS qtdEquipamentos
            FROM Usuarios u
            LEFT JOIN Equipamentos e ON e.Usuarios_idUsuario = u.idUsuario
            GROUP BY u.idUsuario
            ORDER BY u.nomeUsuario";
    $res = mysqli_query($conn, $sql) or die('Erro ao listar usuários: ' . mysqli_error($conn));
?>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-4">
        <div class="card border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-3">Equipamentos por Usuário</h2>
                <p class="text-muted">Lista de usuários com quantidade de equipamentos atribuídos.</p>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Setor</th>
                            <th>Nível</th>
                            <th>Qtd Equip.</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>\n";
                                echo "<td>" . $row['idUsuario'] . "</td>\n";
                                echo "<td>" . htmlspecialchars($row['nomeUsuario']) . "</td>\n";
                                echo "<td>" . htmlspecialchars($row['emailUsuario']) . "</td>\n";
                                echo "<td>" . htmlspecialchars($row['setorUsuario']) . "</td>\n";
                                echo "<td>" . htmlspecialchars($row['nivelUsuario']) . "</td>\n";
                                echo "<td>" . intval($row['qtdEquipamentos']) . "</td>\n";
                                echo "<td><a href='listaEquipamentosPorUsuarioDetalhe.php?idUsuario=" . $row['idUsuario'] . "' class='btn btn-sm btn-outline-primary'>Ver equipamentos</a></td>\n";
                                echo "</tr>\n";
                            }
                        ?>
                    </tbody>
                </table>

                <div class="mt-3">
                    <a href="index.php" class="btn btn-outline-secondary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php" ?>
