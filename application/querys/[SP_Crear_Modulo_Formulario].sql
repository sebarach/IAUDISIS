USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Crear_Modulo_Formulario]    Script Date: 17-05-2018 10:52:44 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Crear_Modulo_Formulario]

@idFormulario bigint,
@name nvarchar(200),
@estado int

AS
BEGIN
	INSERT INTO ModuloFormulario 
	 OUTPUT inserted.ID_ModuloFormulario as identidad
     VALUES(@idFormulario,@name,@estado)
END

GO


