<?php

    error_reporting(0); //Desabilita alertas de erros de execução
    session_start();

    if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){ //Verifica se há sessão ativa
        $idUsuario    = $_SESSION['idUsuario']; //Armazenar as variáveis de sessão em variáveis PHP
        $nomeUsuario  = $_SESSION['nomeUsuario'];
        $emailUsuario = $_SESSION['emailUsuario'];
        $nivelUsuario = $_SESSION['nivelUsuario'];

        $nomeCompleto = explode(' ', $nomeUsuario); //Usa a função explode para fragmentar o nome do usuário
        $primeiroNome = $nomeCompleto[0]; //Armazena na variável o primeiro [0] fragmento do nome do usuário
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <?php
        //Configura o fuso horário para America/São Paulo
        date_default_timezone_set('America/Sao_Paulo');
    ?>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>TechDesk - Gestão de Equipamentos e Chamados de TI</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- CDN para ícones do Bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Bootstrap CSS via CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <!-- Core theme CSS -->
        <link href="css/styles.css" rel="stylesheet" />

        <style>
            :root {
                --azul-escuro: #0d2b4e;
                --azul-medio: #1565a8;
                --azul-claro: #4ab8d8;
            }

            body {
                font-family: 'Segoe UI', Arial, sans-serif;
            }

            /* Navbar estilo corporativo */
            .navbar {
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }

            .navbar-brand {
                font-weight: 700;
                color: var(--azul-escuro) !important;
                letter-spacing: 0.5px;
            }

            .navbar-brand i {
                color: var(--azul-claro);
            }

            .navbar .nav-link {
                color: #333 !important;
                font-weight: 500;
            }

            .navbar .nav-link:hover {
                color: var(--azul-medio) !important;
            }

            /* Header com imagem de fundo industrial + overlay azul */
            .header-sgti {
                position: relative;
                overflow: hidden;
                background-color: var(--azul-escuro); /* fallback se a imagem não carregar */
                background-image: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1600&q=80');
                background-size: cover;
                background-position: center;
            }

            .header-sgti::before {
                content: "";
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                background: linear-gradient(120deg, rgba(13,43,78,0.92) 0%, rgba(21,101,168,0.88) 55%, rgba(74,184,216,0.75) 100%);
            }

            .header-sgti .icone-destaque {
                font-size: 3.5rem;
                color: rgba(255,255,255,0.95);
            }

            .header-sgti h1 {
                font-weight: 800;
                letter-spacing: 1px;
            }

            .btn-azul {
                background-color: var(--azul-medio);
                border-color: var(--azul-medio);
                color: white;
            }

            .btn-azul:hover {
                background-color: var(--azul-escuro);
                border-color: var(--azul-escuro);
                color: white;
            }

            /* Faixa diagonal de chamado fechado */
            .faixa-fechado {
                position: absolute;
                top: 0%;
                right: 0;
                width: 50%;
                background: #198754;
                color: white;
                text-align: center;
                font-weight: bold;
                font-size: 0.7rem;
                padding: 5px 0;
                z-index: 10;
                box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            }

            /* Deixa a imagem em preto e branco (equipamento baixado) */
            .imagem-baixada {
                filter: grayscale(100%);
                opacity: 0.8;
            }

            .card-hover .card-img-top {
                background-color: #f4f6f8;
            }
        </style>

    </head>
    <body>
        <!-- Barra de Navegação-->
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php"><i class="bi bi-hdd-network-fill me-1"></i>TechDesk</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Início</a></li>
                        <?php
                            if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                                echo "<li class='nav-item'><a class='nav-link' href='formAbrirChamado.php'>Abrir Chamado</a></li>";
                                echo "<li class='nav-item'><a class='nav-link' href='formItens.php'>Incluir Itens</a></li>";
                                echo "<li class='nav-item'><a class='nav-link' href='formSolicitarTroca.php'>Troca por Perda</a></li>";
                                echo "<li class='nav-item'><a class='nav-link' href='listarChamados.php'>Chamados</a></li>";
                            }
                        ?>
                    </ul>

                    <ul class="navbar-nav mb-2 mb-lg-0 ms-lg-4">
                        <?php
                            if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){ //Verifica se há sessão ativa
                                if($nivelUsuario == 'administrador'){
                                    echo "
                                        <li class='nav-item dropdown'>
                                            <a class='nav-link dropdown-toggle' id='navbarDropdown' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-person-circle'></i>&nbsp$primeiroNome</a>
                                            <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>
                                                <li><a class='dropdown-item' href='formEquipamento.php'>Cadastrar Equipamento</a></li>
                                                <li><a class='dropdown-item' href='formAbrirChamado.php'>Abrir Chamado</a></li>
                                                <li><a class='dropdown-item' href='painelTI.php'>Painel TI</a></li>
                                                <li><a class='dropdown-item' href='listaEquipamentosPorUsuario.php'>Equipamentos por Usuário</a></li>
                                                <li><hr class='dropdown-divider' /></li>
                                                <li><a class='dropdown-item' href='listarRegistrosTabela.php'>Gerenciar Equipamentos</a></li>
                                                <li><a class='dropdown-item' href='listarChamados.php'>Gerenciar Chamados</a></li>
                                                <li><hr class='dropdown-divider' /></li>
                                                <li><a class='dropdown-item' href='logout.php'>Sair</a></li>
                                            </ul>
                                        </li>
                                    ";
                                }
                                else if($nivelUsuario == 'ti'){
                                    echo "
                                        <li class='nav-item dropdown'>
                                            <a class='nav-link dropdown-toggle' id='navbarDropdown' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-headset'></i>&nbsp$primeiroNome</a>
                                            <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>
                                                <li><a class='dropdown-item' href='painelTI.php'>Painel TI</a></li>
                                                <li><a class='dropdown-item' href='listaEquipamentosPorUsuario.php'>Equipamentos por Usuário</a></li>
                                                <li><a class='dropdown-item' href='listarChamados.php'>Receber Chamados</a></li>
                                                <li><a class='dropdown-item' href='listarUsuarios.php'>Listar Usuários</a></li>
                                                <li><hr class='dropdown-divider' /></li>
                                                <li><a class='dropdown-item' href='logout.php'>Sair</a></li>
                                            </ul>
                                        </li>
                                    ";
                                }
                                else{
                                    echo "
                                        <li class='nav-item dropdown'>
                                            <a class='nav-link dropdown-toggle' id='navbarDropdown' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-person-circle'></i>&nbsp$primeiroNome</a>
                                            <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>
                                                <li><a class='dropdown-item' href='formEquipamento.php'>Registrar meu equipamento</a></li>
                                                <li><a class='dropdown-item' href='formAbrirChamado.php'>Abrir Chamado</a></li>
                                                <li><hr class='dropdown-divider' /></li>
                                                <li><a class='dropdown-item' href='meusEquipamentos.php'>Meus Equipamentos</a></li>
                                                <li><a class='dropdown-item' href='meusChamados.php'>Meus Chamados</a></li>
                                                <li><hr class='dropdown-divider' /></li>
                                                <li><a class='dropdown-item' href='logout.php'>Sair</a></li>
                                            </ul>
                                        </li>
                                    ";
                                }
                            }
                            else{
                                echo "<li class='nav-item'><a class='nav-link' aria-current='page' href='formLogin.php' title='Acessar o Sistema'>Login</a></li>";
                                echo "<li class='nav-item'><a class='nav-link' href='formUsuario.php' title='Criar uma conta'>Cadastre-se</a></li>";
                            }

                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="header-sgti py-5">
            <div class="container px-4 px-lg-5 my-5" style="position: relative; z-index: 2;">
                <div class="text-center text-white">
                    <i class="bi bi-pc-display icone-destaque"></i>
                    <h1 class="mt-3">TECHDESK</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Gestão centralizada de equipamentos e chamados de TI.</p>
                    <?php
                        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                            echo "<div class='mt-4'><a class='btn btn-light btn-lg' href='index.php'>Acessar painel</a></div>";
                        }
                        else{
                            echo "<div class='mt-4'>
                                    <a class='btn btn-light btn-lg me-2' href='formUsuario.php'>Criar conta</a>
                                    <a class='btn btn-outline-light btn-lg' href='formLogin.php'>Entrar</a>
                                  </div>";
                        }
                    ?>
                </div>
            </div>
        </header>