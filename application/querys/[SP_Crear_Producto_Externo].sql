USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Crear_Producto_Externo]    Script Date: 17-05-2018 10:54:04 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Crear_Producto_Externo]

@name nvarchar(200)

AS
BEGIN
	INSERT INTO ProductoExterno
     VALUES(@name,'',1)
END

GO


