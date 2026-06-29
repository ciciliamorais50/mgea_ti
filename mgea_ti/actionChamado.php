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

// Validação dos valores
$prioridadesPermitidas = array('Baixa', 'Média', 'Alta', 'Crítica');
if(!in_array($prioridade, $prioridadesPermitidas)) $prioridade = 'Média';

$statusChamado = 'Aberto'; // Sempre inicia como Aberto

// Validações de segurança
if($idUsuario <= 0){
    $_SESSION['erroChamado'] = 'Usuário inválido.';
    header("Location: formAbrirChamado.php");
    exit;
}

if($idItemCategoria <= 0){
    $_SESSION['erroChamado'] = 'Categoria inválida.';
    header("Location: formAbrirChamado.php");
    exit;
}

if($descricaoProblema === ''){
    $_SESSION['erroChamado'] = 'Descrição do problema é obrigatória.';
    header("Location: formAbrirChamado.php");
    exit;
}

if($sistemaRelacionado === ''){
    $_SESSION['erroChamado'] = 'Sistema relacionado é obrigatório.';
    header("Location: formAbrirChamado.php");
    exit;
}

// Verifica se o usuário existe
$verificarUsuario = "SELECT idUsuario FROM Usuarios WHERE idUsuario = $idUsuario LIMIT 1";
$resUser = mysqli_query($conn, $verificarUsuario);
if(mysqli_num_rows($resUser) == 0){
    $_SESSION['erroChamado'] = 'Usuário não encontrado.';
    header("Location: formAbrirChamado.php");
    exit;
}

// Verifica se a categoria existe
$verificarCategoria = "SELECT idItemCategoria FROM itens_categoria WHERE idItemCategoria = $idItemCategoria LIMIT 1";
$resCat = mysqli_query($conn, $verificarCategoria);
if(mysqli_num_rows($resCat) == 0){
    $_SESSION['erroChamado'] = 'Categoria não encontrada.';
    header("Location: formAbrirChamado.php");
    exit;
}

// Insere o chamado
$sql = "INSERT INTO chamados (idUsuario, idItemCategoria, sistemaRelacionado, descricaoProblema, prioridade, dataAbertura, statusChamado)
        VALUES ($idUsuario, $idItemCategoria, '$sistemaRelacionado', '$descricaoProblema', '$prioridade', '$dataAbertura', '$statusChamado')";

$res = mysqli_query($conn, $sql);
if(!$res){
    $_SESSION['erroChamado'] = 'Erro ao enviar chamado: ' . mysqli_error($conn);
} else {
    $_SESSION['sucessoChamado'] = 'Beleza, seu chamado foi registrado. O TI vai analisar.';
}

header("Location: formAbrirChamado.php");
exit;
