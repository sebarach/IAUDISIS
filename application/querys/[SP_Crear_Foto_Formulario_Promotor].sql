USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Crear_Foto_Formulario_Promotor]    Script Date: 17-05-2018 10:52:24 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Crear_Foto_Formulario_Promotor]

@idForm bigint,
@arch nvarchar(500),
@orden int

AS
BEGIN
	INSERT INTO FotosFormularioPromotor
     VALUES(@idForm,@orden,@arch)
END

GO


