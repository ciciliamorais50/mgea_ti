<?php
include "conexaoBD.php";
session_start();

if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
    header("Location: formLogin.php");
    exit;
}

if(isset($_POST['itens'])){
    foreach($_POST['itens'] as $item){
        $nomeItem = trim($item['nomeItem']);
        $descricaoItem = trim($item['descricaoItem']);
        $dataCadastro = $item['dataCadastro'];
        $numeroSerie = trim($item['numeroSerie']);
        $contaOffice = trim($item['contaOffice']);

        if(!empty($nomeItem)){
            $sql = "INSERT INTO itens_categoria (nomeItem, descricaoItem, dataCadastro, numeroSerie, contaOffice, criadoPor)
                    VALUES ('" . mysqli_real_escape_string($conn, $nomeItem) . "', '" . mysqli_real_escape_string($conn, $descricaoItem) . "', '" . mysqli_real_escape_string($conn, $dataCadastro) . "', '" . mysqli_real_escape_string($conn, $numeroSerie) . "', '" . mysqli_real_escape_string($conn, $contaOffice) . "', " . intval($_SESSION['idUsuario']) . ")";
            mysqli_query($conn, $sql);
        }
    }
}

header("Location: formItens.php");
exit;
