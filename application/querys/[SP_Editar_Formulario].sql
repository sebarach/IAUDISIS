USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Editar_Formulario]    Script Date: 17-05-2018 10:54:53 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Editar_Formulario]
	-- Add the parameters for the stored procedure here
@id bigint,
@name varchar(100),
@id_cliente int
AS
BEGIN

UPDATE Formulario SET Nombre=@name, ID_Cliente=@id_cliente
 WHERE ID_Formulario=@id

END


GO


