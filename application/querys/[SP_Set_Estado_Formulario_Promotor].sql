USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Set_Estado_Formulario_Promotor]    Script Date: 17-05-2018 11:03:35 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Set_Estado_Formulario_Promotor]

@id_form bigint,
@estado int

AS
BEGIN
	UPDATE FormularioPromotor SET Estado=@estado WHERE ID_Formulario_Promotor=@id_form
END

GO


