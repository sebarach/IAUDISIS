USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Editar_Pregunta]    Script Date: 17-05-2018 11:00:14 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Editar_Pregunta]
	-- Add the parameters for the stored procedure here
@id bigint,
@idProdCompetidor bigint,
@name varchar(200),
@type int,
@orden int,
@estado int
AS
BEGIN

UPDATE Pregunta SET Pregunta=@name,ID_Producto_Competidor=@idProdCompetidor,ID_Tipo_Dato=@type,Orden=@orden,Estado=@estado
 Where ID_Pregunta=@id

END


GO


