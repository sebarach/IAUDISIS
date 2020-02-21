USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Crear_Producto_Cliente]    Script Date: 17-05-2018 10:53:23 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Crear_Producto_Cliente]

@name nvarchar(200),
@idCliente int

AS
BEGIN
	INSERT INTO ProductoCliente
     VALUES(@name,@idCliente,1)
END

GO


