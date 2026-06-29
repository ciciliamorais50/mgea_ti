<?php
    include "header.php";
    include "conexaoBD.php";

    //Verifica se o usuário é administrador
    if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['nivelUsuario'] != 'administrador'){
        echo "
            <div class='container mt-5'>
                <div class='alert alert-secondary text-center'>Só admin pode excluir chamados.</div>
            </div>
        ";
        include "footer.php";
        exit;
    }

    //Verifica se o idChamado foi enviado pela URL
    if(isset($_GET['idChamado'])){
        $idChamado = $_GET['idChamado'];

        //QUERY para excluir o chamado
        $excluirChamado = "DELETE FROM Chamados WHERE idChamado = $idChamado";

        if(mysqli_query($conn, $excluirChamado)){
            echo "
                <div class='container mt-5'>
                    <div class='alert alert-secondary text-center'>Chamado excluído. Tudo certo.</div>
                    <div class='text-center'><a href='listarChamados.php' class='btn btn-outline-dark'>Voltar à listagem</a></div>
                </div>
            ";
        }
        else{
            echo "
                <div class='container mt-5'>
                    <div class='alert alert-secondary text-center'>Não deu pra excluir o chamado. Tenta de novo.</div>
                </div>
            ";
        }
    }
    else{
        echo "
            <div class='container mt-5'>
                <div class='alert alert-secondary text-center'>Nenhum chamado foi selecionado.</div>
            </div>
        ";
    }

    include "footer.php";
?>
