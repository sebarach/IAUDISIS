USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Crear_Formulario_Code]    Script Date: 17-05-2018 10:51:37 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
create PROCEDURE [dbo].[SP_Crear_Formulario_Code]

@idForm bigint,
@code nvarchar(max)

AS
BEGIN
	INSERT INTO FormularioCodeView
     VALUES(@idForm,@code)
END

GO


