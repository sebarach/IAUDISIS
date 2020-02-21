USE [AppAu]
GO

/****** Object:  Table [dbo].[FormularioPromotor]    Script Date: 17-05-2018 10:44:50 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[FormularioPromotor](
	[ID_Formulario_Promotor] [bigint] IDENTITY(1,1) NOT NULL,
	[ID_Formulario] [bigint] NOT NULL,
	[ID_Cliente] [int] NOT NULL,
	[ID_Perfil_Formulario] [int] NULL,
	[ID_Punto_Activacion] [int] NULL,
	[Max_Intento] [int] NULL,
	[Estado] [int] NOT NULL,
 CONSTRAINT [ID_Formulario_Promotor_PK] PRIMARY KEY CLUSTERED 
(
	[ID_Formulario_Promotor] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO


