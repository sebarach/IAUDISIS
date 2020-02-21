USE [AppAu]
GO

/****** Object:  Table [dbo].[ModuloFormulario]    Script Date: 17-05-2018 10:45:33 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[ModuloFormulario](
	[ID_ModuloFormulario] [bigint] IDENTITY(1,1) NOT NULL,
	[ID_Formulario] [bigint] NOT NULL,
	[Nombre] [nvarchar](200) NOT NULL,
	[Estado] [int] NOT NULL,
 CONSTRAINT [ID_ModuloFormulario_PK] PRIMARY KEY CLUSTERED 
(
	[ID_ModuloFormulario] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO


