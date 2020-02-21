USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Set_Count_Respuesta]    Script Date: 17-05-2018 11:02:47 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Set_Count_Respuesta]

@idPS bigint

AS
BEGIN
	DECLARE @cont int;
	SELECT @cont=formulario FROM PuntoActivacionUsuario WHERE ID_PuntoActivacionUsuario=@idPS;
	UPDATE PuntoActivacionUsuario SET formulario=@cont+1 WHERE ID_PuntoActivacionUsuario=@idPS;
END

GO


