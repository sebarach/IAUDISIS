USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Crear_Producto_Competidor]    Script Date: 17-05-2018 10:53:41 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Crear_Producto_Competidor]

@idExterno bigint,
@idCliente int

AS
BEGIN
	INSERT INTO ProductoCompetidor
     VALUES(@idExterno,@idCliente,1)
END

GO


