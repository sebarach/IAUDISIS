USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Eliminar_Formulario_Code]    Script Date: 17-05-2018 11:00:50 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Eliminar_Modulo]
	-- Add the parameters for the stored procedure here
@idForm bigint

AS
BEGIN

DELETE FROM FormularioCodeView Where ID_Formulario=@idForm

END


GO


