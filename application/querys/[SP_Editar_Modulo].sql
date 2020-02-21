USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Editar_Modulo]    Script Date: 17-05-2018 10:55:29 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Editar_Modulo]
	-- Add the parameters for the stored procedure here
@id bigint,
@name varchar(200),
@estado int
AS
BEGIN

UPDATE ModuloFormulario SET Nombre=@name, Estado=@estado
 WHERE ID_ModuloFormulario=@id

END


GO


