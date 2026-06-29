-- ============================================
-- Banco de Dados: SGTI (Sistema de Gestão de TI)
-- Baseado na estrutura do ShopTB
-- ============================================

CREATE DATABASE IF NOT EXISTS sgti;
USE sgti;

-- Remove as tabelas para evitar conflito ao importar novamente
DROP TABLE IF EXISTS Chamados;
DROP TABLE IF EXISTS Equipamentos;
DROP TABLE IF EXISTS Usuarios;

-- ============================================
-- Tabela: Usuarios
-- ============================================
CREATE TABLE Usuarios (
    idUsuario               INT AUTO_INCREMENT PRIMARY KEY,
    fotoUsuario             VARCHAR(255) NOT NULL,
    nomeUsuario             VARCHAR(100) NOT NULL,
    dataNascimentoUsuario   DATE NOT NULL,
    setorUsuario            VARCHAR(50) NOT NULL,
    emailUsuario            VARCHAR(100) NOT NULL UNIQUE,
    senhaUsuario            VARCHAR(32) NOT NULL,
    nivelUsuario            VARCHAR(20) NOT NULL DEFAULT 'usuario'
);

-- ============================================
-- Tabela: Equipamentos
-- ============================================
CREATE TABLE Equipamentos (
    idEquipamento           INT AUTO_INCREMENT PRIMARY KEY,
    Usuarios_idUsuario      INT NOT NULL,
    fotoEquipamento         VARCHAR(255) NOT NULL,
    nomeEquipamento         VARCHAR(100) NOT NULL,
    tipoEquipamento         VARCHAR(50) NOT NULL,
    patrimonioEquipamento   VARCHAR(50) NOT NULL,
    descricaoEquipamento    TEXT NOT NULL,
    dataEquipamento         DATE NOT NULL,
    horaEquipamento         TIME NOT NULL,
    statusEquipamento       VARCHAR(20) NOT NULL DEFAULT 'ativo',
    CONSTRAINT fk_equipamento_usuario
        FOREIGN KEY (Usuarios_idUsuario) REFERENCES Usuarios(idUsuario)
);

-- ============================================
-- Tabela: Chamados
-- ============================================
CREATE TABLE Chamados (
    idChamado               INT AUTO_INCREMENT PRIMARY KEY,
    Usuarios_idUsuario      INT NOT NULL,
    Equipamentos_idEquipamento INT NOT NULL,
    dataChamado             DATE NOT NULL,
    horaChamado             TIME NOT NULL,
    descricaoChamado        TEXT NOT NULL,
    prioridadeChamado       VARCHAR(20) NOT NULL DEFAULT 'media',
    statusChamado           VARCHAR(20) NOT NULL DEFAULT 'aberto',
    CONSTRAINT fk_chamado_usuario
        FOREIGN KEY (Usuarios_idUsuario) REFERENCES Usuarios(idUsuario),
    CONSTRAINT fk_chamado_equipamento
        FOREIGN KEY (Equipamentos_idEquipamento) REFERENCES Equipamentos(idEquipamento)
);

-- ============================================
-- Usuário administrador padrão (senha: admin123)
-- ============================================
INSERT IGNORE INTO Usuarios (fotoUsuario, nomeUsuario, dataNascimentoUsuario, setorUsuario, emailUsuario, senhaUsuario, nivelUsuario)
VALUES ('assets/img/default.png', 'Administrador do Sistema', '1990-01-01', 'TI', 'admin@sgti.com', MD5('admin123'), 'administrador');
