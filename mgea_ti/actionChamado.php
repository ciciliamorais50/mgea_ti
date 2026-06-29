<?php
session_start();
include "conexaoBD.php";

// Se o usuário não estiver logado, nem tenta enviar nada.
if(!isset($_SESSION['logado']) || $_SESSION['logado'] !== true){
    header("Location: formLogin.php");
    exit;
}

// Limpa o input antes de usar.
$idUsuario = intval($_POST['idUsuario'] ?? 0);
$idItemCategoria = intval($_POST['idItemCategoria'] ?? 0);
$sistemaRelacionado = mysqli_real_escape_string($conn, trim($_POST['sistemaRelacionado'] ?? ''));
$descricaoProblema = mysqli_real_escape_string($conn, trim($_POST['descricaoProblema'] ?? ''));
$prioridade = mysqli_real_escape_string($conn, trim($_POST['prioridade'] ?? ''));
$dataAbertura = mysqli_real_escape_string($conn, trim($_POST['dataAbertura'] ?? ''));
$statusChamado = mysqli_real_escape_string($conn, trim($_POST['statusChamado'] ?? ''));

if($idUsuario > 0 && $idItemCategoria > 0 && $descricaoProblema !== '' && $sistemaRelacionado !== ''){
    $sql = "INSERT INTO chamados (idUsuario, idItemCategoria, sistemaRelacionado, descricaoProblema, prioridade, dataAbertura, statusChamado)
            VALUES ($idUsuario, $idItemCategoria, '$sistemaRelacionado', '$descricaoProblema', '$prioridade', '$dataAbertura', '$statusChamado')";
    $res = mysqli_query($conn, $sql);
    if(!$res){
        $_SESSION['erroChamado'] = 'Erro ao enviar chamado: ' . mysqli_error($conn);
    } else {
        $_SESSION['sucessoChamado'] = 'Beleza, seu chamado foi registrado. O TI vai analisar.';
    }
} else {
    $_SESSION['erroChamado'] = 'Faltou algum campo. Preenche direitinho e tenta de novo.';
}

header("Location: formAbrirChamado.php");
exit;
