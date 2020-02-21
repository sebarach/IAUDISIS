USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Set_Activo_Local]    Script Date: 17-05-2018 11:02:31 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[SP_Set_Activo_Local]

@id_Local int,
@activo bit

AS
BEGIN
	UPDATE Local SET activo=@activo WHERE id_Local=@id_Local
END


GO


