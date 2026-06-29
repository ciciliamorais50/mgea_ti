<?php
    include "header.php";
    include "conexaoBD.php";

    //Verifica se o usuário é administrador
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['nivelUsuario'] != 'administrador'){
        echo "
            <div class='container mt-5'>
                <div class='alert alert-danger text-center'>Apenas administradores podem excluir equipamentos!</div>
            </div>
        ";
        include "footer.php";
        exit;
    }

    //Verifica se o idEquipamento foi enviado pela URL
    if(isset($_GET['idEquipamento'])){
        $idEquipamento = $_GET['idEquipamento'];

        //Verifica se existem chamados vinculados a este equipamento (nota: estrutura atual não usa essa relação)
        $verificarChamados = "SELECT idChamado FROM chamados LIMIT 0";
        $resChamados = mysqli_query($conn, $verificarChamados);

        if(mysqli_num_rows($resChamados) > 0){
            echo "
                <div class='container mt-5'>
                    <div class='alert alert-warning text-center'>Este equipamento possui <strong>chamados vinculados</strong> e não pode ser excluído!</div>
                    <div class='text-center'><a href='listarRegistrosTabela.php' class='btn btn-outline-dark'>Voltar</a></div>
                </div>
            ";
        }
        else{
            //QUERY para excluir o equipamento
            $excluirEquipamento = "DELETE FROM Equipamentos WHERE idEquipamento = $idEquipamento";

            if(mysqli_query($conn, $excluirEquipamento)){
                echo "
                    <div class='container mt-5'>
                        <div class='alert alert-success text-center'><strong>EQUIPAMENTO</strong> excluído com sucesso!</div>
                        <div class='text-center'><a href='listarRegistrosTabela.php' class='btn btn-outline-dark'>Voltar à listagem</a></div>
                    </div>
                ";
            }
            else{
                echo "
                    <div class='container mt-5'>
                        <div class='alert alert-danger text-center'>Erro ao tentar excluir o equipamento!</div>
                    </div>
                ";
            }
        }
    }
    else{
        echo "
            <div class='container mt-5'>
                <div class='alert alert-danger text-center'>Nenhum equipamento foi selecionado!</div>
            </div>
        ";
    }

    include "footer.php";
?>
