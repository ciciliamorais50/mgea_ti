<!-- Inclui o header.php -->
<?php include "header.php" ?>

    <?php

        //Verifica se o usuário é administrador
        if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['nivelUsuario'] != 'administrador'){
            header("location:formLogin.php");
            exit;
        }
    
        //Verifica o método de requisição do servidor
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $erroPreenchimento = false;

            if(empty($_POST['idChamado'])){
                echo "<div class='alert alert-warning text-center'>O chamado não foi identificado!</div>";
                $erroPreenchimento = true;
            }
            else{
                $idChamado = filtrar_entrada($_POST['idChamado']);
            }

            if(empty($_POST['statusChamado'])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>STATUS</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $statusChamado = filtrar_entrada($_POST['statusChamado']);
            }

            //Se NÃO houver erro de preenchimento
            if(!$erroPreenchimento){

                $atualizarChamado = "
                    UPDATE chamados
                    SET statusChamado = '$statusChamado'
                    WHERE idChamado = $idChamado
                ";

                include "conexaoBD.php";

                if(mysqli_query($conn, $atualizarChamado)){
                    echo "
                        <div class='container mt-3'>
                            <div class='alert alert-secondary text-center'>Chamado atualizado com sucesso!</div>
                            <div class='text-center mb-5'>
                                <a href='listarChamados.php' class='btn btn-outline-dark'>
                                    <i class='bi bi-list-task me-1'></i>
                                    Voltar à listagem de chamados
                                </a>
                            </div>
                        </div>
                    ";
                }
                else{
                    echo "<div class='alert alert-secondary text-center'>Deu ruim ao atualizar o chamado: " . mysqli_error($conn) . "</div>";
                }
            }

        }
        else{
            header("location:listarChamados.php");
        }

        //Função para filtrar entrada de dados
        function filtrar_entrada($dado){
            $dado = trim($dado);
            $dado = stripslashes($dado);
            $dado = htmlspecialchars($dado);
            return($dado);
        }
    
    ?>

<!-- Inclui o footer.php -->
<?php include "footer.php" ?>
