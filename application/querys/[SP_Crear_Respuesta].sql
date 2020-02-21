USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Crear_Respuesta]    Script Date: 17-05-2018 10:54:28 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[SP_Crear_Respuesta]

@idPregunta bigint,
@idUser int,
@idLocal bigint,
@idPA bigint,
@resp nvarchar(200),
@pau bigint

AS
BEGIN
	INSERT INTO Respuesta(ID_Pregunta,ID_Usuario,Fecha_Registro,ID_Local,ID_Punto_Activacion,Respuesta,ID_PuntoActivacionUsuario)
     VALUES(@idPregunta,@idUser,GETDATE(),@idLocal,@idPA,@resp,@pau)
END

GO


