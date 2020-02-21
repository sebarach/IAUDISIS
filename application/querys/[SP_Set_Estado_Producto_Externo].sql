USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Set_Estado_Producto_Externo]    Script Date: 17-05-2018 11:04:29 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[SP_Set_Estado_Producto_Externo]

@id_prod bigint,
@estado int

AS
BEGIN
	UPDATE ProductoExterno SET Estado=@estado WHERE ID_Producto_Externo=@id_prod
END

GO


