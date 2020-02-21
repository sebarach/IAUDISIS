USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Crear_Formulario]    Script Date: 17-05-2018 10:51:17 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Crear_Formulario]

@idCliente int,
@name nvarchar(100),
@estado int

AS
BEGIN
	INSERT INTO Formulario(Nombre,ID_Cliente,Estado) 
	 OUTPUT inserted.ID_Formulario as identidad
     VALUES(@name,@idCliente,@estado)
END

GO


