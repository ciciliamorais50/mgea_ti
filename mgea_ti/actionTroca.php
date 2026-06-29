<?php
include "conexaoBD.php";
session_start();

if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
    header("Location: formLogin.php");
    exit;
}

$idUsuario = intval($_POST['idUsuario']);
$nomeEquipamento = trim($_POST['nomeEquipamento']);
$numeroSerie = trim($_POST['numeroSerie']);
$contaOffice = trim($_POST['contaOffice']);
$motivoPerda = trim($_POST['motivoPerda']);
$dataOcorrencia = trim($_POST['dataOcorrencia']);
$dataSolicitacao = date('Y-m-d');

if(!empty($nomeEquipamento) && !empty($motivoPerda)){
    $sql = "INSERT INTO solicitacoes_troca (idUsuario, nomeEquipamento, numeroSerie, contaOffice, motivoPerda, dataOcorrencia, dataSolicitacao)
            VALUES ($idUsuario, '" . mysqli_real_escape_string($conn, $nomeEquipamento) . "', '" . mysqli_real_escape_string($conn, $numeroSerie) . "', '" . mysqli_real_escape_string($conn, $contaOffice) . "', '" . mysqli_real_escape_string($conn, $motivoPerda) . "', '" . mysqli_real_escape_string($conn, $dataOcorrencia) . "', '" . mysqli_real_escape_string($conn, $dataSolicitacao) . "')";
    mysqli_query($conn, $sql);
}

header("Location: formSolicitarTroca.php");
exit;
