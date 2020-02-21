USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Set_Estado_Formulario]    Script Date: 17-05-2018 11:03:09 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Set_Estado_Formulario]

@id_form int,
@estado int

AS
BEGIN
	UPDATE Formulario SET Estado=@estado WHERE ID_Formulario=@id_form
END

GO


