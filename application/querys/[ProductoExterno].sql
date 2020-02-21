USE [AppAu]
GO

/****** Object:  Table [dbo].[ProductoExterno]    Script Date: 17-05-2018 10:47:30 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[ProductoExterno](
	[ID_Producto_Externo] [bigint] IDENTITY(1,1) NOT NULL,
	[Nombre_Producto] [nvarchar](200) NOT NULL,
	[Marca] [nvarchar](100) NOT NULL,
	[Estado] [int] NOT NULL,
 CONSTRAINT [ProductoExterno_PK] PRIMARY KEY CLUSTERED 
(
	[ID_Producto_Externo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO


