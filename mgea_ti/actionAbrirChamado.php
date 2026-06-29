<!-- Inclui o header.php -->
<?php include "header.php" ?>

    <?php

        //Verifica se há sessão ativa
        if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
            header("location:formLogin.php");
            exit;
        }
    
        //Verifica o método de requisição do servidor
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Define o bloco de variáveis para armazenar as informações recebidas do formulário
            $idEquipamento = $prioridadeChamado = $descricaoChamado = $dataChamado = $horaChamado = "";

            //Variável booleana para controle de erros de preenchimento
            $erroPreenchimento = false;

            //Captura a data e a hora do servidor
            $dataChamado = date("Y-m-d");
            $horaChamado = date("H:i:s");

            //Captura o id do usuário logado
            $idUsuario = $_SESSION['idUsuario'];

            //Validação do campo Equipamentos_idEquipamento
            if(empty($_POST["Equipamentos_idEquipamento"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>EQUIPAMENTO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $idEquipamento = filtrar_entrada($_POST["Equipamentos_idEquipamento"]);
            }

            //Validação do campo prioridadeChamado
            if(empty($_POST["prioridadeChamado"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>PRIORIDADE</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $prioridadeChamado = filtrar_entrada($_POST["prioridadeChamado"]);
            }

            //Validação do campo descricaoChamado
            if(empty($_POST["descricaoChamado"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DESCRIÇÃO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $descricaoChamado = filtrar_entrada($_POST["descricaoChamado"]);
            }

            //Se NÃO houver erro de preenchimento
            if(!$erroPreenchimento){

                //Criar uma variável para armazenar a QUERY que realiza a inserção do Chamado
                $inserirChamado = "INSERT INTO Chamados (Usuarios_idUsuario, Equipamentos_idEquipamento, dataChamado, horaChamado, descricaoChamado, prioridadeChamado, statusChamado)
                                    VALUES ('$idUsuario', '$idEquipamento', '$dataChamado', '$horaChamado', '$descricaoChamado', '$prioridadeChamado', 'aberto')";

                //Inclui o arquivo de conexão com o Banco de Dados
                include "conexaoBD.php";

                //Se conseguir executar a QUERY para inserção, exibe alerta de sucesso e a tabela com os dados informados
                if(mysqli_query($conn, $inserirChamado)){

                    echo "<div class='container'>";
                        echo "<div class='alert alert-secondary text-center'>Chamado aberto. Já saiu do forno.</div>";
                        echo "
                            <div class='container mt-3'>
                                <table class='table'>
                                    <tr>
                                        <th>PRIORIDADE</th>
                                        <td>$prioridadeChamado</td>
                                    </tr>
                                    <tr>
                                        <th>DESCRIÇÃO</th>
                                        <td>$descricaoChamado</td>
                                    </tr>
                                    <tr>
                                        <th>DATA</th>
                                        <td>$dataChamado às $horaChamado</td>
                                    </tr>
                                </table>

                                <div class='text-center mb-5'>
                                    <a href='meusChamados.php' class='btn btn-outline-dark'>
                                        <i class='bi bi-list-task me-1'></i>
                                        Ver Meus Chamados
                                    </a>
                                </div>
                            </div>
                        ";
                    echo "</div>";
                }
                else{
                    echo "<div class='alert alert-secondary text-center'>Não rolou abrir o chamado. Tenta de novo.</div>" . mysqli_error($conn);
                }
            }

        }
        else{
            //Usa a função "header()" para redirecionar o usuário
            header("location:formAbrirChamado.php");
        }

        //Função para filtrar entrada de dados
        function filtrar_entrada($dado){
            $dado = trim($dado); //Remove espaços desnecessários
            $dado = stripslashes($dado); //Remove barras invertidas
            $dado = htmlspecialchars($dado); //Converte caracteres especiais em entidades HTML

            //Retorna o dado após filtrado
            return($dado);
        }
    
    ?>

<!-- Inclui o footer.php -->
<?php include "footer.php" ?>
