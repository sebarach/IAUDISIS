USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Crear_Pregunta]    Script Date: 17-05-2018 10:53:00 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[SP_Crear_Pregunta]

@idFormulario bigint,
@idExterno bigint,
@tipoExterno int,
@name nvarchar(200),
@type int,
@orden int,
@estado int

AS
BEGIN
	INSERT INTO Pregunta 
     VALUES(@idFormulario,@idExterno,@tipoExterno,@name,@type,@orden,@estado);

END

GO


