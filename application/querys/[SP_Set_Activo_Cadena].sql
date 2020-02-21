USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Set_Activo_Cadena]    Script Date: 17-05-2018 11:02:10 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[SP_Set_Activo_Cadena]

@id_cadena int,
@activo bit

AS
BEGIN
	UPDATE Cadena SET activo=@activo WHERE id_Cadena=@id_cadena
END


GO


