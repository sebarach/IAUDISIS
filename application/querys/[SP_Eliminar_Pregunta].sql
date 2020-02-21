USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Eliminar_Pregunta]    Script Date: 17-05-2018 11:01:33 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Eliminar_Pregunta]
	-- Add the parameters for the stored procedure here
@id bigint
AS
BEGIN

DELETE FROM Pregunta Where ID_Pregunta=@id

END


GO


