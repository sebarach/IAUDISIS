USE [AppAu]
GO

/****** Object:  Table [dbo].[FormularioCodeView]    Script Date: 17-05-2018 10:44:26 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[FormularioCodeView](
	[ID_Formulario_Code_View] [bigint] IDENTITY(1,1) NOT NULL,
	[ID_Formulario] [bigint] NOT NULL,
	[Code] [nvarchar](max) NULL,
 CONSTRAINT [ID_Formulario_Code_View_PK] PRIMARY KEY CLUSTERED 
(
	[ID_Formulario_Code_View] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO

ALTER TABLE [dbo].[FormularioCodeView]  WITH CHECK ADD FOREIGN KEY([ID_Formulario])
REFERENCES [dbo].[Formulario] ([ID_Formulario])
GO


