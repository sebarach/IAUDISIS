USE [AppAu]
GO

/****** Object:  Table [dbo].[ProductoCompetidor]    Script Date: 17-05-2018 10:46:57 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[ProductoCompetidor](
	[ID_Producto_Competidor] [bigint] IDENTITY(1,1) NOT NULL,
	[ID_Producto_Externo] [bigint] NOT NULL,
	[ID_Cliente] [int] NOT NULL,
	[Estado] [int] NOT NULL,
 CONSTRAINT [ID_Producto_Competidor_PK] PRIMARY KEY CLUSTERED 
(
	[ID_Producto_Competidor] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO


