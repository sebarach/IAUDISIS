USE [AppAu]
GO

/****** Object:  Table [dbo].[FotosFormularioPromotor]    Script Date: 17-05-2018 10:45:14 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[FotosFormularioPromotor](
	[ID_Foto_Formulario_Promotor] [bigint] IDENTITY(1,1) NOT NULL,
	[ID_Formulario_Promotor] [bigint] NOT NULL,
	[Orden] [int] NOT NULL,
	[Foto] [nvarchar](500) NULL,
 CONSTRAINT [ID_Foto_Formulario_Promotor_PK] PRIMARY KEY CLUSTERED 
(
	[ID_Foto_Formulario_Promotor] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO


