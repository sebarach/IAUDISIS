

CREATE TABLE Clientes 
    (
     ID_Cliente INTEGER IDENTITY(1,1) NOT NULL , 
     Nombre NVARCHAR (100) NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     Activo BIT NOT NULL , 
     ID_UserCreador INTEGER NOT NULL , 
     EmailCliente NVARCHAR (100) , 
     FK_Empresas_ID_empresa INTEGER NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Clientes ADD CONSTRAINT Clientes_PK PRIMARY KEY CLUSTERED (ID_Cliente, FK_Empresas_ID_Empresa)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Empresas 
    (
     ID_Empresa INTEGER IDENTITY(1,1) NOT NULL , 
     RutEmpresa NVARCHAR (12) NOT NULL , 
     RazonSocial NVARCHAR (100) NOT NULL , 
     Activo BIT NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     ID_UserCreador BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Empresas ADD CONSTRAINT Empresas_PK PRIMARY KEY CLUSTERED (ID_Empresa)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Grupo_Usuarios 
    (
     ID_GrupoUsuario INTEGER IDENTITY(1,1) NOT NULL , 
     NombreGrupoUsuario NVARCHAR (50) NOT NULL , 
     Activo BIT NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     ID_UserCreador INTEGER NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Grupo_Usuarios ADD CONSTRAINT Grupo_Usuarios_PK PRIMARY KEY CLUSTERED (ID_GrupoUsuario)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE IT_Grupo_Usuarios 
    (
     ID_UnionGrupoUsuario BIGINT IDENTITY(1,1) NOT NULL , 
     Activo BIT NOT NULL , 
     FK_Usuarios_ID_Usuario BIGINT NOT NULL , 
     FK_Usuarios_Clientes_ID_Cliente INTEGER NOT NULL , 
     FK_Usuarios_Clientes_Empresas_ID_empresa INTEGER NOT NULL , 
     FK_Usuarios_Perfiles_ID_Perfil INTEGER NOT NULL , 
     FK_Grupo_Usuarios_ID_GrupoUsuario INTEGER NOT NULL      
    )
    ON "default"
GO

ALTER TABLE IT_Grupo_Usuarios ADD CONSTRAINT IT_Grupo_Usuarios_PK PRIMARY KEY CLUSTERED (ID_UnionGrupoUsuario, FK_Usuarios_ID_Usuario, FK_Usuarios_Clientes_ID_Cliente, FK_Usuarios_Clientes_Empresas_ID_empresa, FK_Usuarios_Perfiles_ID_Perfil,FK_Grupo_Usuarios_ID_GrupoUsuario)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE IT_Modulos 
    (
     ID_IT_Modulos BIGINT IDENTITY(1,1) NOT NULL , 
     Activo BIT NOT NULL , 
     FK_Usuarios_ID_usuario BIGINT NOT NULL , 
     FK_Modulos_ID_Modulo INTEGER NOT NULL , 
     FK_Usuarios_Clientes_ID_Cliente INTEGER NOT NULL , 
     FK_Usuarios_Clientes_Empresas_ID_empresa INTEGER NOT NULL , 
     FK_Usuarios_Perfiles_ID_Perfil INTEGER NOT NULL 
    )
    ON "default"
GO

ALTER TABLE IT_Modulos ADD CONSTRAINT IT_Modulos_PK PRIMARY KEY CLUSTERED (ID_IT_Modulos, FK_Usuarios_ID_usuario, FK_Modulos_ID_Modulo, FK_Usuarios_Clientes_ID_Cliente, FK_Usuarios_Clientes_Empresas_ID_empresa, FK_Usuarios_Perfiles_ID_Perfil)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Modulos 
    (
     ID_Modulo INTEGER IDENTITY(1,1) NOT NULL , 
     NombreModulo NVARCHAR NOT NULL , 
     Activo BIT NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     id_userCreador BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Modulos ADD CONSTRAINT Modulos_PK PRIMARY KEY CLUSTERED (ID_Modulo)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
GO

CREATE TABLE Perfiles
    (
     ID_Perfil INTEGER IDENTITY(1,1) NOT NULL , 
     NombrePerfil NVARCHAR NOT NULL , 
     Activo BIT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Perfiles ADD CONSTRAINT Perfiles_PK PRIMARY KEY CLUSTERED (ID_Perfil)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Usuarios 
    (
     ID_Usuario BIGINT IDENTITY(1,1) NOT NULL , 
     Rut NVARCHAR (12) NOT NULL , 
     Nombres NVARCHAR (100) NOT NULL , 
     ApellidoP NVARCHAR (100) NOT NULL , 
     ApellidoM NVARCHAR (100) , 
     Genero NVARCHAR (100) NOT NULL , 
     Telefono INTEGER NOT NULL , 
     Email NVARCHAR (200) NOT NULL , 
     Direccion NVARCHAR (200) , 
     FotoPerfil NVARCHAR (350) , 
     Cargo NVARCHAR (20) NOT NULL , 
     Activo BIT NOT NULL , 
     ID_Creador INTEGER NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     FK_Clientes_ID_Cliente INTEGER NOT NULL , 
     FK_Clientes_Empresas_ID_empresa INTEGER NOT NULL , 
     FK_Perfiles_ID_Perfil INTEGER NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Usuarios ADD CONSTRAINT Usuarios_PK PRIMARY KEY CLUSTERED (ID_Usuario, FK_Clientes_ID_Cliente, FK_Clientes_Empresas_ID_empresa, FK_Perfiles_ID_Perfil)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

ALTER TABLE Clientes 
    ADD CONSTRAINT Clientes_Empresas_FK FOREIGN KEY 
    ( 
     FK_Empresas_ID_empresa
    ) 
    REFERENCES Empresas
    ( 
     ID_Empresa 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE IT_Grupo_Usuarios 
    ADD CONSTRAINT IT_Grupo_Usuarios_Grupo_Usuarios_FK FOREIGN KEY 
    ( 
     FK_Grupo_Usuarios_ID_GrupoUsuario
    ) 
    REFERENCES Grupo_Usuarios
    ( 
     ID_GrupoUsuario 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE IT_Grupo_Usuarios 
    ADD CONSTRAINT IT_Grupo_Usuarios_Usuarios_FK FOREIGN KEY 
    ( 
     FK_Usuarios_ID_usuario, 
     FK_Usuarios_Clientes_ID_Cliente, 
     FK_Usuarios_Clientes_Empresas_ID_empresa, 
     FK_Usuarios_Perfiles_ID_Perfil
    ) 
    REFERENCES Usuarios 
    ( 
     ID_Usuario , 
     FK_Clientes_ID_Cliente , 
     FK_Clientes_Empresas_ID_empresa , 
     FK_Perfiles_ID_Perfil 

    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE IT_Modulos 
    ADD CONSTRAINT IT_Modulos_Modulos_FK FOREIGN KEY 
    ( 
     FK_Modulos_ID_Modulo
    ) 
    REFERENCES Modulos 
    ( 
     ID_Modulo
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE IT_Modulos 
    ADD CONSTRAINT IT_Modulos_Usuarios_FK FOREIGN KEY 
    ( 
     FK_Usuarios_ID_usuario, 
     FK_Usuarios_Clientes_ID_Cliente, 
     FK_Usuarios_Clientes_Empresas_ID_empresa, 
     FK_Usuarios_Perfiles_ID_Perfil
    ) 
    REFERENCES Usuarios 
    ( 
     ID_Usuario , 
     FK_Clientes_ID_Cliente , 
     FK_Clientes_Empresas_ID_empresa , 
     FK_Perfiles_ID_Perfil 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE Usuarios
    ADD CONSTRAINT Usuarios_Clientes_FK FOREIGN KEY 
    ( 
     FK_Clientes_ID_Cliente, 
     FK_Clientes_Empresas_ID_empresa
    ) 
    REFERENCES Clientes 
    ( 
     ID_Cliente , 
     FK_Empresas_ID_empresa 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE Usuarios
    ADD CONSTRAINT Usuarios_Perfiles_FK FOREIGN KEY 
    ( 
     FK_Perfiles_ID_Perfil
    ) 
    REFERENCES Perfiles 
    ( 
     ID_Perfil 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO


