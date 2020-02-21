USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Crear_Formulario_Promotor]    Script Date: 17-05-2018 10:51:51 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[SP_Crear_Formulario_Promotor]

@idForm bigint,
@idCliente int,
@idPerfil int,
@idPA int,
@maxIntento int

AS
BEGIN
	INSERT INTO FormularioPromotor
     VALUES(@idForm,@idCliente,@idPerfil,@idPA,@maxIntento,1)
END

GO


