USE [AppAu]
GO

/****** Object:  StoredProcedure [dbo].[SP_Editar_Formulario_Promotor]    Script Date: 17-05-2018 10:55:07 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[SP_Editar_Formulario_Promotor]

@idFormPro bigint,
@idCliente int,
@idPerfil int,
@idPA int,
@maxIntento int

AS
BEGIN
	UPDATE FormularioPromotor SET ID_Cliente=@idCliente,ID_Perfil_Formulario=@idPerfil,ID_Punto_Activacion=@idPA,
	Max_Intento=@maxIntento WHERE ID_Formulario_Promotor=@idFormPro
END

GO


