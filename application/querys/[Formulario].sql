USE [AppAu]
GO

/****** Object:  Table [dbo].[Formulario]    Script Date: 17-05-2018 10:43:30 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[Formulario](
	[ID_Formulario] [bigint] IDENTITY(1,1) NOT NULL,
	[Nombre] [nvarchar](100) NOT NULL,
	[ID_Cliente] [int] NOT NULL,
	[Estado] [int] NOT NULL,
 CONSTRAINT [ID_Formulario_PK] PRIMARY KEY CLUSTERED 
(
	[ID_Formulario] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO


