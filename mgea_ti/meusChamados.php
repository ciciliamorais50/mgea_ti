<?php include "header.php" ?>

<div class="container mt-3 mb-3">

    <?php
        //Verifica se há sessão ativa
        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
            //Inclui conexão com o Banco de Dados
            include "conexaoBD.php";
            //Query para listar os chamados do usuário logado
            $listarChamados = "
                SELECT 
                    Chamados.idChamado,
                    Chamados.dataChamado,
                    Chamados.horaChamado,
                    Chamados.prioridadeChamado,
                    Chamados.descricaoChamado,
                    Chamados.statusChamado,

                    Equipamentos.idEquipamento,
                    Equipamentos.fotoEquipamento,
                    Equipamentos.nomeEquipamento

                FROM Chamados
                INNER JOIN Equipamentos
                    ON Chamados.Equipamentos_idEquipamento = Equipamentos.idEquipamento
                WHERE Chamados.Usuarios_idUsuario = " . $_SESSION['idUsuario'] . "
                ORDER BY Chamados.idChamado DESC
            ";

            //Executa a query
            $res = mysqli_query($conn, $listarChamados)
                   or die("Erro ao tentar listar chamados!");

            //Captura a quantidade de registros retornados
            $totalChamados = mysqli_num_rows($res);

            //Exibe mensagem com total de chamados
            if($totalChamados > 0){
                    echo "<div class='alert alert-secondary text-center'>Você tem <strong>$totalChamados</strong> chamado(s) aqui.</div>";
                }
                else{
                    echo "<div class='alert alert-secondary text-center'>Ainda não tem chamados registrados.</div>";

            //Cabeçalho da tabela
            echo "
                <table class='table table-hover align-middle'>
                    <thead class='table-dark'>
                        <tr>
                            <th>ID</th>
                            <th>EQUIPAMENTO</th>
                            <th>PRIORIDADE</th>
                            <th>DESCRIÇÃO</th>
                            <th>DATA</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
            ";

            //Enquanto houver registros
            while($registro = mysqli_fetch_assoc($res)){

                $idChamado         = $registro['idChamado'];
                $nomeEquipamento   = $registro['nomeEquipamento'];
                $prioridadeChamado = $registro['prioridadeChamado'];
                $descricaoChamado  = $registro['descricaoChamado'];
                $dataChamado       = $registro['dataChamado'];
                $diaChamado        = substr($dataChamado, 8, 2);
                $mesChamado        = substr($dataChamado, 5, 2);
                $anoChamado        = substr($dataChamado, 0, 4);
                $statusChamado     = $registro['statusChamado'];

                //Define a cor do badge de status
                if($statusChamado == 'aberto'){
                    $badge = "<span class='badge bg-light text-dark border'>Aberto</span>";
                }
                else if($statusChamado == 'em_andamento'){
                    $badge = "<span class='badge bg-light text-dark border'>Em andamento</span>";
                }
                else{
                    $badge = "<span class='badge bg-light text-dark border'>Fechado</span>";
                }

                //Exibe os registros na tabela
                echo "
                    <tr>
                        <td>$idChamado</td>
                        <td>$nomeEquipamento</td>
                        <td>$prioridadeChamado</td>
                        <td>" . htmlspecialchars($descricaoChamado) . "</td>
                        <td>$diaChamado/$mesChamado/$anoChamado</td>
                        <td>$badge</td>
                    </tr>
                ";
            }

            //Fecha tabela
            echo "
                    </tbody>
                </table>
            ";

            //Fecha conexão com banco
            mysqli_close($conn);
        }
        else{
            //Redireciona caso usuário não esteja logado
            header('location:formLogin.php');
        }

    ?>

</div>

<?php include "footer.php" ?>
