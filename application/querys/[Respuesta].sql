USE [AppAu]
GO

/****** Object:  Table [dbo].[Respuesta]    Script Date: 17-05-2018 10:48:06 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[Respuesta](
	[ID_Respuesta] [bigint] IDENTITY(1,1) NOT NULL,
	[ID_Pregunta] [bigint] NOT NULL,
	[ID_Usuario] [int] NOT NULL,
	[Respuesta] [nvarchar](500) NOT NULL,
	[Fecha_Registro] [datetime] NOT NULL,
	[ID_Local] [bigint] NOT NULL,
	[ID_Punto_Activacion] [bigint] NOT NULL,
	[ID_PuntoActivacionUsuario] [bigint] NULL,
 CONSTRAINT [ID_Respuesta_PK] PRIMARY KEY CLUSTERED 
(
	[ID_Respuesta] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO


