-- Generado por Oracle SQL Developer Data Modeler 17.2.0.188.1059
--   en:        2018-08-21 16:24:34 CLST
--   sitio:      SQL Server 2008
--   tipo:      SQL Server 2008



CREATE TABLE Asistencia 
    (
     ID_Asistencia BIGINT IDENTITY(1,1) NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     Latitud FLOAT NOT NULL , 
     Longitud FLOAT NOT NULL , 
     ID_Usuario BIGINT NOT NULL , 
     Comentario NVARCHAR (100) , 
    FK_Incidencias_ID_Incidencias BIGINT NOT NULL , 
    FK_Marcage_ID_Marcage BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Asistencia ADD CONSTRAINT Asistencia_PK PRIMARY KEY CLUSTERED (ID_Asistencia,FK_Incidencias_ID_incidencias,FK_Marcage_ID_Marcage)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Cadena 
    (
     ID_Cadena BIGINT IDENTITY(1,1) NOT NULL , 
     NombreCadena NVARCHAR (50) NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     ID_userCreador BIGINT NOT NULL , 
     Activo BIT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Cadena ADD CONSTRAINT Cadena_PK PRIMARY KEY CLUSTERED (ID_Cadena)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Estados 
    (
     ID_Estado BIGINT IDENTITY(1,1) NOT NULL , 
     NombreEstado NVARCHAR (50) NOT NULL , 
     FechaResgistro DATETIME NOT NULL , 
     Activo BIT NOT NULL , 
     ID_Creador BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Estados ADD CONSTRAINT Estados_PK PRIMARY KEY CLUSTERED (ID_Estado)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Grupo_Locales 
    (
     ID_Grupolocal BIGINT IDENTITY(1,1) NOT NULL , 
     NombreGL NVARCHAR NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     ID_userCreador BIGINT NOT NULL , 
     Activo BIT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Grupo_Locales ADD CONSTRAINT Grupo_Locales_PK PRIMARY KEY CLUSTERED (ID_Grupolocal)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Horarios 
    (
     ID_Horario BIGINT IDENTITY(1,1) NOT NULL , 
     ID_Usuario BIGINT NOT NULL , 
     Dia INTEGER NOT NULL , 
     Mes INTEGER NOT NULL , 
     Anio INTEGER NOT NULL , 
     Entrada DATETIME NOT NULL , 
     Salida DATETIME NOT NULL , 
     Activo BIT NOT NULL , 
     ID_userCreador BIGINT NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     FK_Jornadas_ID_Jornada BIGINT NOT NULL , 
     FK_Jornadas_Locales_ID_Local BIGINT NOT NULL , 
     FK_Jornadas_Locales_Cadenas_ID_Cadena BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Horarios ADD CONSTRAINT Horarios_PK PRIMARY KEY CLUSTERED (ID_Horario,FK_Jornadas_ID_Jornada, FK_Jornadas_Locales_ID_Local,FK_Jornadas_Locales_Cadenas_ID_Cadena)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Incidencias 
    (
     ID_Incidencias BIGINT IDENTITY(1,1) NOT NULL , 
     NombreIncidencia NVARCHAR (50) NOT NULL , 
     Activo BIT NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     ID_UserCreador BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Incidencias ADD CONSTRAINT Incidencias_PK PRIMARY KEY CLUSTERED (ID_Incidencias)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Jornadas 
    (
     ID_Jornada BIGINT IDENTITY(1,1) NOT NULL , 
     ID_Usuario BIGINT NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     Activo BIT NOT NULL , 
     ID_UserCreador BIGINT NOT NULL , 
     FK_Locales_ID_Local BIGINT NOT NULL , 
     FK_Locales_Cadena_ID_Cadena BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Jornadas ADD CONSTRAINT Jornadas_PK PRIMARY KEY CLUSTERED (id_Jornada,FK_Locales_ID_Local,FK_Locales_Cadena_ID_Cadena)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Locales 
    (
     ID_Local BIGINT IDENTITY(1,1) NOT NULL , 
     NombreLocal NVARCHAR NOT NULL , 
     Direccion NVARCHAR (100) NOT NULL , 
     Latitud FLOAT NOT NULL , 
     Longitud FLOAT NOT NULL , 
     Activo BIT NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     ID_UserCreador BIGINT NOT NULL , 
     Rango FLOAT , 
     FK_Cadena_ID_cadena BIGINT NOT NULL , 
     ID_Comuna BIGINT NOT NULL , 
     ID_Region BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Locales ADD CONSTRAINT Locales_PK PRIMARY KEY CLUSTERED (ID_Local,FK_Cadena_ID_cadena)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Marcage 
    (
     ID_Marcage BIGINT IDENTITY(1,1) NOT NULL , 
     NombreMarcage NVARCHAR (50) NOT NULL , 
     Activo BIT NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     ID_Creador BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Marcage ADD CONSTRAINT Marcage_PK PRIMARY KEY CLUSTERED (ID_Marcage)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Operacional 
    (
     ID_Operacional BIGINT IDENTITY(1,1) NOT NULL , 
     ID_Usuario BIGINT NOT NULL , 
     Estado BIT , 
     Latitud FLOAT NOT NULL , 
     Longitud FLOAT NOT NULL , 
     Comentario NVARCHAR (100) , 
     FechaResgistro DATETIME NOT NULL , 
     FechaModificacion DATETIME , 
     ID_userCreador BIGINT NOT NULL , 
     Activo BIT NOT NULL , 
    FK_Tareas_ID_Tarea BIGINT NOT NULL ,  
    FK_Tareas_Jornadas_ID_Jornada BIGINT NOT NULL , 
     FK_Tareas_Jornadas_Locales_ID_Local BIGINT NOT NULL , 
    FK_Tareas_Jornadas_Locales_Cadena_ID_cadena BIGINT NOT NULL , 
    FK_Estados_ID_Estado BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Operacional ADD CONSTRAINT Operacional_PK PRIMARY KEY CLUSTERED (ID_Operacional,FK_Tareas_ID_Tarea, FK_Tareas_Jornadas_ID_Jornada,FK_Tareas_Jornadas_Locales_ID_Local,FK_Estados_ID_Estado)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE Tareas 
    (
     ID_Tarea BIGINT IDENTITY(1,1) NOT NULL , 
     NombreTarea NVARCHAR (50) NOT NULL , 
     FechaIncio DATETIME NOT NULL , 
     FechaFin DATETIME NOT NULL , 
     Detalle NVARCHAR (100) NOT NULL , 
     Activo BIT NOT NULL , 
     FechaRegistro DATETIME NOT NULL , 
     Id_UserCreador BIGINT NOT NULL , 
     FK_Jornadas_ID_Jornada BIGINT NOT NULL , 
     FK_Jornadas_Locales_ID_Local BIGINT NOT NULL , 
     FK_Jornadas_Locales_Cadenas_ID_Cadena BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE Tareas ADD CONSTRAINT Tareas_PK PRIMARY KEY CLUSTERED (ID_Tarea,FK_Jornadas_ID_Jornada, FK_Jornadas_Locales_ID_Local,FK_Jornadas_Locales_Cadenas_ID_Cadena)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

CREATE TABLE TI_GCL 
    (
     ID_GCL BIGINT IDENTITY(1,1) NOT NULL , 
     ID_GrupLocal BIGINT NOT NULL , 
     Activo BIT NOT NULL , 
    FK_Locales_ID_Local BIGINT NOT NULL , 
    FK_Grupo_Locales_ID_Grupolocal BIGINT NOT NULL , 
    FK_Locales_Cadena_ID_Cadena BIGINT NOT NULL 
    )
    ON "default"
GO

ALTER TABLE TI_GCL ADD CONSTRAINT TI_GCL_PK PRIMARY KEY CLUSTERED (id_GCL,FK_Locales_ID_Local,FK_Locales_Cadena_ID_Cadena,FK_Grupo_Locales_ID_Grupolocal)
     WITH (
     ALLOW_PAGE_LOCKS = ON , 
     ALLOW_ROW_LOCKS = ON )
     ON "default" 
    GO

ALTER TABLE Asistencia 
    ADD CONSTRAINT Asistencia_Incidencias_FK FOREIGN KEY 
    ( 
    FK_Incidencias_ID_incidencias
    ) 
    REFERENCES Incidencias 
    ( 
     ID_Incidencias 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE Asistencia 
    ADD CONSTRAINT Asistencia_Marcage_FK FOREIGN KEY 
    ( 
    FK_Marcage_ID_Marcage
    ) 
    REFERENCES Marcage 
    ( 
     ID_Marcage 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE Horarios 
    ADD CONSTRAINT Horarios_Jornadas_FK FOREIGN KEY 
    ( 
    FK_Jornadas_ID_Jornada, 
     FK_Jornadas_Locales_ID_Local, 
    FK_Jornadas_Locales_Cadenas_ID_Cadena
    ) 
    REFERENCES Jornadas 
    ( 
     ID_Jornada , 
    FK_Locales_ID_Local , 
    FK_Locales_Cadena_ID_Cadena 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE Jornadas 
    ADD CONSTRAINT Jornadas_Locales_FK FOREIGN KEY 
    ( 
    FK_Locales_ID_Local, 
    FK_Locales_Cadena_ID_Cadena
    ) 
    REFERENCES Locales 
    ( 
     ID_Local , 
    FK_Cadena_ID_cadena 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE Locales 
    ADD CONSTRAINT Locales_Cadena_FK FOREIGN KEY 
    ( 
    FK_Cadena_ID_cadena
    ) 
    REFERENCES Cadena 
    ( 
     ID_cadena 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE Operacional 
    ADD CONSTRAINT Operacional_Estados_FK FOREIGN KEY 
    ( 
    FK_Estados_ID_Estado
    ) 
    REFERENCES Estados 
    ( 
     ID_Estado 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE Operacional 
    ADD CONSTRAINT Operacional_Tareas_FK FOREIGN KEY 
    ( 
    FK_Tareas_ID_Tarea, 
    FK_Tareas_Jornadas_ID_Jornada, 
    FK_Tareas_Jornadas_Locales_ID_Local, 
    FK_Tareas_Jornadas_Locales_Cadena_ID_cadena
    ) 
    REFERENCES Tareas 
    ( 
     ID_Tarea , 
    FK_Jornadas_ID_Jornada , 
     FK_Jornadas_Locales_ID_Local , 
    FK_Jornadas_Locales_Cadenas_ID_Cadena 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE Tareas 
    ADD CONSTRAINT Tareas_Jornadas_FK FOREIGN KEY 
    ( 
    FK_Jornadas_ID_Jornada, 
     FK_Jornadas_Locales_ID_Local, 
    FK_Jornadas_Locales_Cadenas_ID_Cadena
    ) 
    REFERENCES Jornadas 
    ( 
     ID_Jornada , 
    FK_Locales_ID_Local , 
    FK_Locales_Cadena_ID_Cadena 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE TI_GCL 
    ADD CONSTRAINT TI_GCL_Grupo_Locales_FK FOREIGN KEY 
    ( 
    FK_Grupo_Locales_ID_Grupolocal
    ) 
    REFERENCES Grupo_Locales 
    ( 
     ID_Grupolocal 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO

ALTER TABLE TI_GCL 
    ADD CONSTRAINT TI_GCL_Locales_FK FOREIGN KEY 
    ( 
    FK_Locales_ID_Local, 
    FK_Locales_Cadena_ID_Cadena
    ) 
    REFERENCES Locales 
    ( 
     ID_Local , 
    FK_Cadena_ID_cadena 
    ) 
    ON DELETE NO ACTION 
    ON UPDATE NO ACTION 
GO



-- Informe de Resumen de Oracle SQL Developer Data Modeler: 
-- 
-- CREATE TABLE                            12
-- CREATE INDEX                             0
-- ALTER TABLE                             22
-- CREATE VIEW                              0
-- ALTER VIEW                               0
-- CREATE PACKAGE                           0
-- CREATE PACKAGE BODY                      0
-- CREATE PROCEDURE                         0
-- CREATE FUNCTION                          0
-- CREATE TRIGGER                           0
-- ALTER TRIGGER                            0
-- CREATE DATABASE                          0
-- CREATE DEFAULT                           0
-- CREATE INDEX ON VIEW                     0
-- CREATE ROLLBACK SEGMENT                  0
-- CREATE ROLE                              0
-- CREATE RULE                              0
-- CREATE SCHEMA                            0
-- CREATE PARTITION FUNCTION                0
-- CREATE PARTITION SCHEME                  0
-- 
-- DROP DATABASE                            0
-- 
-- ERRORS                                   0
-- WARNINGS                                 0
