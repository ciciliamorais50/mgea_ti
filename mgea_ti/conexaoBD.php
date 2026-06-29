<?php

    $hostBD   = "localhost"; //Define o local do servidor de BD
    $userBD   = "root"; //Define o usuário do BD (Padrão: root)
    $senhaBD  = ""; //Define a senha do BD (Padrão: "" [Em branco])
    $database = "sgti"; //Define com qual base será realizada a conexão

    //Função do PHP para estabelecer a conexão com o BD
    $conn = mysqli_connect($hostBD, $userBD, $senhaBD);

    //Verificar se há conexão com o BD
    if(!$conn){
        echo "<p>Erro ao tentar conectar a aplicação ao servidor de banco de dados.</p>";
        exit();
    }

    //Cria a base caso ainda não exista
    if(!mysqli_select_db($conn, $database)){
        if(!mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `{$database}`")){
            echo "<p>Erro ao tentar criar a base de dados <strong>$database</strong>.</p>";
            exit();
        }
        mysqli_select_db($conn, $database);
    }

    mysqli_set_charset($conn, "utf8");

    //Cria as tabelas somente se ainda não existirem
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS Usuarios (
        idUsuario INT AUTO_INCREMENT PRIMARY KEY,
        fotoUsuario VARCHAR(255) NOT NULL,
        nomeUsuario VARCHAR(100) NOT NULL,
        dataNascimentoUsuario DATE NOT NULL,
        setorUsuario VARCHAR(50) NOT NULL,
        emailUsuario VARCHAR(100) NOT NULL UNIQUE,
        senhaUsuario VARCHAR(32) NOT NULL,
        nivelUsuario VARCHAR(20) NOT NULL DEFAULT 'usuario'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4") or die("Erro ao criar a tabela Usuarios.");

    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS Equipamentos (
        idEquipamento INT AUTO_INCREMENT PRIMARY KEY,
        Usuarios_idUsuario INT NOT NULL,
        fotoEquipamento VARCHAR(255) NOT NULL,
        nomeEquipamento VARCHAR(100) NOT NULL,
        tipoEquipamento VARCHAR(50) NOT NULL,
        patrimonioEquipamento VARCHAR(50) NOT NULL,
        descricaoEquipamento TEXT NOT NULL,
        numeroSerieEquipamento VARCHAR(100) DEFAULT NULL,
        contaOfficeEquipamento VARCHAR(150) DEFAULT NULL,
        dataEquipamento DATE NOT NULL,
        horaEquipamento TIME NOT NULL,
        statusEquipamento VARCHAR(20) NOT NULL DEFAULT 'ativo',
        CONSTRAINT fk_equipamento_usuario
            FOREIGN KEY (Usuarios_idUsuario) REFERENCES Usuarios(idUsuario)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4") or die("Erro ao criar a tabela Equipamentos.");

    mysqli_query($conn, "ALTER TABLE Equipamentos ADD COLUMN IF NOT EXISTS numeroSerieEquipamento VARCHAR(100) DEFAULT NULL");
    mysqli_query($conn, "ALTER TABLE Equipamentos ADD COLUMN IF NOT EXISTS contaOfficeEquipamento VARCHAR(150) DEFAULT NULL");

    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS itens_categoria (
        idItemCategoria INT AUTO_INCREMENT PRIMARY KEY,
        nomeItem VARCHAR(100) NOT NULL,
        descricaoItem TEXT,
        dataCadastro DATE NOT NULL,
        numeroSerie VARCHAR(100) DEFAULT NULL,
        contaOffice VARCHAR(150) DEFAULT NULL,
        criadoPor INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT fk_item_usuario FOREIGN KEY (criadoPor) REFERENCES Usuarios(idUsuario)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4") or die("Erro ao criar a tabela itens_categoria.");

    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS chamados (
        idChamado INT AUTO_INCREMENT PRIMARY KEY,
        idUsuario INT NOT NULL,
        idItemCategoria INT NOT NULL,
        sistemaRelacionado VARCHAR(100) NOT NULL,
        descricaoProblema TEXT NOT NULL,
        prioridade VARCHAR(20) NOT NULL,
        dataAbertura DATE NOT NULL,
        statusChamado VARCHAR(30) NOT NULL DEFAULT 'Aberto',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT fk_chamado_usuario FOREIGN KEY (idUsuario) REFERENCES Usuarios(idUsuario),
        CONSTRAINT fk_chamado_item FOREIGN KEY (idItemCategoria) REFERENCES itens_categoria(idItemCategoria)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4") or die("Erro ao criar a tabela chamados.");

    mysqli_query($conn, "ALTER TABLE chamados ADD COLUMN IF NOT EXISTS idUsuario INT NOT NULL DEFAULT 0");
    mysqli_query($conn, "ALTER TABLE chamados ADD COLUMN IF NOT EXISTS idItemCategoria INT NOT NULL DEFAULT 0");
    mysqli_query($conn, "ALTER TABLE chamados ADD COLUMN IF NOT EXISTS sistemaRelacionado VARCHAR(100) NOT NULL DEFAULT 'Outro'");
    mysqli_query($conn, "ALTER TABLE chamados ADD COLUMN IF NOT EXISTS descricaoProblema TEXT NOT NULL DEFAULT 'N/A'");
    mysqli_query($conn, "ALTER TABLE chamados ADD COLUMN IF NOT EXISTS prioridade VARCHAR(20) NOT NULL DEFAULT 'Baixa'");
    mysqli_query($conn, "ALTER TABLE chamados ADD COLUMN IF NOT EXISTS dataAbertura DATE NOT NULL DEFAULT '1970-01-01'");
    mysqli_query($conn, "ALTER TABLE chamados ADD COLUMN IF NOT EXISTS statusChamado VARCHAR(30) NOT NULL DEFAULT 'Aberto'");
    mysqli_query($conn, "ALTER TABLE chamados ADD COLUMN IF NOT EXISTS created_at DATETIME DEFAULT CURRENT_TIMESTAMP");

    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS solicitacoes_troca (
        idSolicitacao INT AUTO_INCREMENT PRIMARY KEY,
        idUsuario INT NOT NULL,
        nomeEquipamento VARCHAR(150) NOT NULL,
        numeroSerie VARCHAR(100) DEFAULT NULL,
        contaOffice VARCHAR(150) DEFAULT NULL,
        motivoPerda TEXT NOT NULL,
        dataOcorrencia DATE NOT NULL,
        dataSolicitacao DATE NOT NULL,
        statusSolicitacao VARCHAR(30) NOT NULL DEFAULT 'Pendente',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT fk_troca_usuario FOREIGN KEY (idUsuario) REFERENCES Usuarios(idUsuario)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4") or die("Erro ao criar a tabela solicitacoes_troca.");

    /*
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS Chamados (
        idChamado INT AUTO_INCREMENT PRIMARY KEY,
        Usuarios_idUsuario INT NOT NULL,
        Equipamentos_idEquipamento INT NOT NULL,
        dataChamado DATE NOT NULL,
        horaChamado TIME NOT NULL,
        descricaoChamado TEXT NOT NULL,
        prioridadeChamado VARCHAR(20) NOT NULL DEFAULT 'media',
        statusChamado VARCHAR(20) NOT NULL DEFAULT 'aberto',
        CONSTRAINT fk_chamado_usuario
            FOREIGN KEY (Usuarios_idUsuario) REFERENCES Usuarios(idUsuario),
        CONSTRAINT fk_chamado_equipamento
            FOREIGN KEY (Equipamentos_idEquipamento) REFERENCES Equipamentos(idEquipamento)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4") or die("Erro ao criar a tabela Chamados.");
    */

    //Insere o usuário administrador somente se ainda não existir
    mysqli_query($conn, "INSERT IGNORE INTO Usuarios (fotoUsuario, nomeUsuario, dataNascimentoUsuario, setorUsuario, emailUsuario, senhaUsuario, nivelUsuario)
        VALUES ('assets/img/default.png', 'Administrador do Sistema', '1990-01-01', 'TI', 'admin@sgti.com', MD5('admin123'), 'administrador')");

    //Insere um usuário Técnico de TI padrão (senha: ti123) se ainda não existir
    mysqli_query($conn, "INSERT IGNORE INTO Usuarios (fotoUsuario, nomeUsuario, dataNascimentoUsuario, setorUsuario, emailUsuario, senhaUsuario, nivelUsuario)
        VALUES ('assets/img/default.png', 'Técnico de TI', '1990-01-01', 'TI', 'ti@sgti.com', MD5('ti123'), 'ti')");

?>