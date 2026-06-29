<?php
    session_start(); //Inicia uma sessão
    session_unset(); //Apaga os registros da sessão
    session_destroy(); //Destrói a sessão

    header("Location: formLogin.php"); //Redireciona o usuário para o formulário de Login
    exit();
?>
