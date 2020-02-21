<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'PhpOffice/PhpPresentation/Autoloader.php';
PhpOffice\PhpPresentation\Autoloader::register();

require_once 'PhpOffice/Common/Autoloader.php';
PhpOffice\Common\Autoloader::register();


use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Shape\Drawing\File;
use PhpOffice\PhpPresentation\Shape\Drawing\Base64;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Shape\RichText\Paragraph;
use PhpOffice\PhpPresentation\Style\Bullet;
use PhpOffice\PhpPresentation\Slide\Background\Image;
use PhpOffice\PhpPresentation\Style\Shadow;


class Ppt_stuff {

	public function pptjsc($logo,$fotos){

		$pptReader = IOFactory::createReader('PowerPoint2007');
		$oPHPPresentation = $pptReader->load(realpath('.') .'/doc/plantilla/PlantillaPPT.pptx');
		$slide = $oPHPPresentation->getSlide(1);

	    $parrafo = $slide->createRichTextShape()
	    	->setWidth(600)
			->setOffsetX(800)
			->setOffsetY(600);
			$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
			$textRun = $parrafo->createTextRun('Minuta Diaria  '.$fotos[0]["fecha"]);
			$textRun->getFont()->setBold(true)
			->setSize(28)
			->setColor(new Color(Color::COLOR_WHITE));

		$oBkgImage = new Image();
		$oBkgImage->setPath(realpath('.') . '\doc\plantilla\logoscadenas\presentacion.png');
		$slide->setBackground($oBkgImage);

		$nombre="";
		$pregunta="";
		$sp=0;
		for($i=0; $i < count($fotos); $i++){
			if($nombre==$fotos[$i]["nombredisecom"]){
				if($fotos[$i]["fk_formulariostipospreguntas_id_formulariotipopregunta"]==8){
					if(!is_null($fotos[$i]["foto"])){
						if($sp==4){
							$sp=0;

							$currentSlide = $oPHPPresentation->createSlide();
							$parrafo = $currentSlide->createRichTextShape()
							->setWidth(800)
							->setOffsetX(30)
							->setOffsetY(20);
							$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
							$textRun = $parrafo->createTextRun($fotos[$i]["nombredisecom"]);
							$textRun->getFont()->setBold(true)
							->setSize(28)
							->setColor(new Color('f57c00'));

							$parrafo = $currentSlide->createRichTextShape()
							->setWidth(800)
							->setOffsetX(30)
							->setOffsetY(58);
							$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
							$textRun = $parrafo->createTextRun($fotos[$i]["codigok"]);
							$textRun->getFont()->setBold(true)
							->setSize(22)
							->setColor(new Color('f57c00'));

							$parrafo = $currentSlide->createRichTextShape()
							->setWidth(800)
							->setOffsetX(30)
							->setOffsetY(96);
							$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
							$textRun = $parrafo->createTextRun('Visitado por: '.$fotos[$i]["nombreformulario"]);
							$textRun->getFont()->setBold(true)
							->setSize(16)
							->setColor(new Color(Color::COLOR_BLACK));

							if(!is_null($fotos[$i]["nombrecadena"])){
								$shape = $currentSlide->createDrawingShape();
							    $shape->setName('Cliente logo')
							        ->setDescription('Cliente logo')
							        ->setPath(realpath('.') . '/'.$fotos[$i]["nombrecadena"])
							        // ->setHeight(80)
									->setWidth(100)
									->setOffsetX(1150)
									->setOffsetY(10);
							}

							$x=140;
							$fy=140;
							$fx=420;
							$cf=1;
						}
					}
				}

			} else {
				$nombre=$fotos[$i]["nombredisecom"];
				$sp=0;
				$currentSlide = $oPHPPresentation->createSlide();
				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(800)
				->setOffsetX(30)
				->setOffsetY(20);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun($fotos[$i]["nombredisecom"]);
				$textRun->getFont()->setBold(true)
				->setSize(28)
				->setColor(new Color('f57c00'));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(800)
				->setOffsetX(30)
				->setOffsetY(58);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun($fotos[$i]["codigok"]);
				$textRun->getFont()->setBold(true)
				->setSize(22)
				->setColor(new Color('f57c00'));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(800)
				->setOffsetX(30)
				->setOffsetY(96);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun('Visitado por: '.$fotos[$i]["nombreformulario"]);
				$textRun->getFont()->setBold(true)
				->setSize(16)
				->setColor(new Color(Color::COLOR_BLACK));

				if(!is_null($fotos[$i]["nombrecadena"])){
					$shape = $currentSlide->createDrawingShape();
					$shape->setName('Cliente logo')
					->setDescription('Cliente logo')
					->setPath(realpath('.') . '/'.$fotos[$i]["nombrecadena"])
							        // ->setHeight(80)
					->setWidth(100)
					->setOffsetX(1150)
					->setOffsetY(10);
				}			

				$x=140;
				$fy=140;
				$fx=420;
				$cf=1;
			}

			if($fotos[$i]["fk_formulariostipospreguntas_id_formulariotipopregunta"]==8){
				if(!is_null($fotos[$i]["foto"])){
					if(file_exists($fotos[$i]["foto"])){
						$oShape = new Base64();
						$imageData = "data:image/jpeg;base64,".base64_encode(file_get_contents($fotos[$i]["foto"]));
						$oShape->setName('PHPPresentation logo')
						->setDescription('PHPPresentation logo')
						->setData($imageData)
						->setResizeProportional(false)
						->setHeight(230)
						->setWidth(370)
						->setOffsetX($fx)
						->setOffsetY($fy)
						->getShadow()
				        ->setVisible(true)
				        ->setDirection(45)
				        ->setColor(new Color("767777"))
				        ->setDistance(12);

						$currentSlide->addShape($oShape);

						$fx+=390;
						if($cf==2){
							$cf=1;
							$fy+=250;
							$fx=420;
						} else {
							$cf+=1;
						}
						$sp+=1;	
					}
				}
			} else {
				if(!is_null($fotos[$i]["nombrepregunta"])){
					if($pregunta!=$fotos[$i]["nombrepregunta"]){
						$pregunta=$fotos[$i]["nombrepregunta"];
						$parrafo = $currentSlide->createRichTextShape()
						->setWidth(400)
						->setOffsetX(10)
						->setOffsetY($x);
						$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_JUSTIFY);
						$parrafo->getActiveParagraph()->getBulletStyle()->setBulletChar('✓');
						$parrafo->getActiveParagraph()->getBulletStyle()->setBulletType(Bullet::TYPE_BULLET);
						$parrafo->getActiveParagraph()->getBulletStyle()->setBulletColor(new Color(Color::COLOR_BLACK));
						$textRun = $parrafo->createTextRun(' '.$fotos[$i]["nombrepregunta"]);
						$textRun->getFont()->setBold(true)
						->setSize(10)
						->setColor(new Color(Color::COLOR_BLACK));
						$x+=20;
					}

					$parrafo = $currentSlide->createRichTextShape()
						->setWidth(400)
						->setOffsetX(13)
						->setOffsetY($x);
						$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_JUSTIFY);
						$parrafo->getActiveParagraph()->getBulletStyle()->setBulletChar('•');
						$parrafo->getActiveParagraph()->getBulletStyle()->setBulletType(Bullet::TYPE_BULLET);
						$parrafo->getActiveParagraph()->getBulletStyle()->setBulletColor(new Color(Color::COLOR_BLACK));
						// $textRun = $parrafo->createTextRun();
						$textRun = $parrafo->createTextRun(' '.$fotos[$i]["respuesta"]);
						$textRun->getFont()->setBold(false)
						->setSize(10)
						->setColor(new Color(Color::COLOR_BLACK));
					if((count(explode(" ", $fotos[$i]["respuesta"]))/10)<1){
						$x+=20;
					} else {
						$x+=(20*(count(explode(" ", $fotos[$i]["respuesta"]))/12));
					}
					
				}
				
			}
			 
		}

		$currentSlide = $oPHPPresentation->createSlide();
		$oBkgImage = new Image();
		$oBkgImage->setPath(realpath('.') . '\doc\plantilla\logoscadenas\final.png');
		$currentSlide->setBackground($oBkgImage);

		$oWriterPPTX = IOFactory::createWriter($oPHPPresentation, 'PowerPoint2007');
	    header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation; charset=UTF-8');
	    header('Content-Disposition: attachment;filename="'.$logo["NombreFormulario"].'.pptx"');
	    header('Cache-Control: max-age=0'); 
	    $oWriterPPTX->save('php://output');

	}

	public function ppttrivia($logo,$fotos){

		$objPHPPowerPoint = new PhpPresentation();


		// Create slide
		$currentSlide = $objPHPPowerPoint->getActiveSlide();


		// Create a shape (drawing)
	    $shape = $currentSlide->createDrawingShape();
	    $shape->setName('Audisis logo')
	        ->setDescription('Audisis logo')
	        ->setPath(realpath('.') . '/PNG/logo-iaudisis.png')
	        ->setWidth(110)
	        ->setHeight(35)
	        ->setOffsetX(25)
	        ->setOffsetY(35);

	    $shape1 = $currentSlide->createDrawingShape();
	    $shape1->setName('Cliente logo')
	        ->setDescription('Cliente logo')
	        ->setPath(realpath('.') . '/'.$logo["logo"])
	        ->setWidth(130)
	        // ->setHeight(40)
	        ->setOffsetX(785)
	        ->setOffsetY(25);


	    // Create a shape (text)
	    $shape = $currentSlide->createRichTextShape()
	        ->setHeight(300)
	        ->setWidth(600)
	        ->setOffsetX(170)
	        ->setOffsetY(140);
	    $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
	    $textRun = $shape->createTextRun($fotos[0]['nombre']);
	    $textRun->getFont()->setBold(true)
	        ->setSize(60)
	        ->setColor(new Color(Color::COLOR_RED));

	    $oBkgImage = new Image();
		$oBkgImage->setPath(realpath('.') . '\PNG\fondo_audisis.png');
		$currentSlide->setBackground($oBkgImage);


		for ($i=0; $i < count($fotos); $i++) {
				$currentSlide = $objPHPPowerPoint->createSlide();
				$shape = $currentSlide->createDrawingShape();
				$shape->setName('Audisis logo')
				->setDescription('Audisis logo')
				->setPath(realpath('.') . '/PNG/logo-iaudisis.png')
				->setWidth(110)
				->setHeight(35)
				->setOffsetX(25)
				->setOffsetY(35);

				$shape1 = $currentSlide->createDrawingShape();
				$shape1->setName('Cliente logo')
				->setDescription('Cliente logo')
				->setPath(realpath('.') . '/'.$logo["logo"])
				->setWidth(130)
					// ->setHeight(40)
				->setOffsetX(785)
				->setOffsetY(25);
				

				$oShape = new Base64();
				$imageData = "data:image/jpeg;base64,".base64_encode(file_get_contents($fotos[$i]["foto"]));
				$oShape->setName('PHPPresentation logo')
				->setDescription('PHPPresentation logo')
				->setData($imageData)
				->setResizeProportional(false)
				->setHeight(470)
				->setWidth(550)
				->setOffsetX(60)
				->setOffsetY(150);


				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(310)
				->setOffsetX(640)
				->setOffsetY(170);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun('Usuario: ');
				$textRun->getFont()->setBold(true)
				->setSize(14)
				->setColor(new Color(Color::COLOR_RED));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(310)
				->setOffsetX(640)
				->setOffsetY(195);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun($fotos[$i]["usuario"]);
				$textRun->getFont()->setBold(true)
				->setSize(14)
				->setColor(new Color(Color::COLOR_BLACK));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(310)
				->setOffsetX(640)
				->setOffsetY(245);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun('Fecha Registro: ');
				$textRun->getFont()->setBold(true)
				->setSize(14)
				->setColor(new Color(Color::COLOR_RED));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(310)
				->setOffsetX(640)
				->setOffsetY(270);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun($fotos[$i]["fecha_registro"]);
				$textRun->getFont()->setBold(true)
				->setSize(14)
				->setColor(new Color(Color::COLOR_BLACK));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(310)
				->setOffsetX(640)
				->setOffsetY(320);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun('Local: ');
				$textRun->getFont()->setBold(true)
				->setSize(14)
				->setColor(new Color(Color::COLOR_RED));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(310)
				->setOffsetX(640)
				->setOffsetY(345);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun($fotos[$i]["nombrelocal"]);
				$textRun->getFont()->setBold(true)
				->setSize(14)
				->setColor(new Color(Color::COLOR_BLACK));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(310)
				->setOffsetX(640)
				->setOffsetY(395);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun('Pregunta: ');
				$textRun->getFont()->setBold(true)
				->setSize(14)
				->setColor(new Color(Color::COLOR_RED));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(310)
				->setOffsetX(640)
				->setOffsetY(420);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun($fotos[$i]["titulopreguntaestatica"]);
				$textRun->getFont()->setBold(true)
				->setSize(14)
				->setColor(new Color(Color::COLOR_BLACK));

				$currentSlide->addShape($oShape);

				$oBkgImage = new Image();
				$oBkgImage->setPath(realpath('.') . '\PNG\fondo_audisis.png');
				$currentSlide->setBackground($oBkgImage);

		}


	    $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
	    header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation; charset=UTF-8');
	    header('Content-Disposition: attachment;filename="'.$fotos[0]['nombre'].'.pptx"');
	    header('Cache-Control: max-age=0'); 
	    $oWriterPPTX->save('php://output');
		
	}

	public function make_ppt($logo,$fotos){

		$objPHPPowerPoint = new PhpPresentation();


		// Create slide
		$currentSlide = $objPHPPowerPoint->getActiveSlide();


		// Create a shape (drawing)
	    $shape = $currentSlide->createDrawingShape();
	    $shape->setName('Audisis logo')
	        ->setDescription('Audisis logo')
	        ->setPath(realpath('.') . '/PNG/logo-iaudisis.png')
	        ->setWidth(110)
	        ->setHeight(35)
	        ->setOffsetX(25)
	        ->setOffsetY(35);

	    $shape1 = $currentSlide->createDrawingShape();
	    $shape1->setName('Cliente logo')
	        ->setDescription('Cliente logo')
	        ->setPath(realpath('.') . '/'.$logo["logo"])
	        ->setWidth(130)
	        // ->setHeight(40)
	        ->setOffsetX(785)
	        ->setOffsetY(25);


	    // Create a shape (text)
	    $shape = $currentSlide->createRichTextShape()
	        ->setHeight(300)
	        ->setWidth(600)
	        ->setOffsetX(170)
	        ->setOffsetY(140);
	    $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
	    $textRun = $shape->createTextRun($logo['NombreFormulario']);
	    $textRun->getFont()->setBold(true)
	        ->setSize(60)
	        ->setColor(new Color(Color::COLOR_RED));

	    $oBkgImage = new Image();
		$oBkgImage->setPath(realpath('.') . '\PNG\fondo_audisis.png');
		$currentSlide->setBackground($oBkgImage);






		for ($i=0; $i < count($fotos); $i++) {
				$currentSlide = $objPHPPowerPoint->createSlide();

				$shape = $currentSlide->createDrawingShape();
				$shape->setName('Audisis logo')
				->setDescription('Audisis logo')
				->setPath(realpath('.') . '/PNG/logo-iaudisis.png')
				->setWidth(110)
				->setHeight(35)
				->setOffsetX(25)
				->setOffsetY(35);

				$shape1 = $currentSlide->createDrawingShape();
				$shape1->setName('Cliente logo')
				->setDescription('Cliente logo')
				->setPath(realpath('.') . '/'.$logo["logo"])
				->setWidth(130)
					// ->setHeight(40)
				->setOffsetX(785)
				->setOffsetY(25);

				$oShape = new Base64();
				$imageData = "data:image/jpeg;base64,".base64_encode(file_get_contents($fotos[$i]["respuesta"]));

				$oShape->setName('PHPPresentation logo')
				->setDescription('PHPPresentation logo')
				->setData($imageData)
				->setResizeProportional(false)
				->setHeight(450)
				->setWidth(560)
				->setOffsetX(80)
				->setOffsetY(150);

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(300)
				->setOffsetX(645)
				->setOffsetY(280);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun('Usuario: ');
				$textRun->getFont()->setBold(true)
				->setSize(16)
				->setColor(new Color(Color::COLOR_RED));


				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(300)
				->setOffsetX(645)
				->setOffsetY(305);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun($fotos[$i]["Nombres"]);
				$textRun->getFont()->setBold(true)
				->setSize(16)
				->setColor(new Color(Color::COLOR_BLACK));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(300)
				->setOffsetX(645)
				->setOffsetY(350);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun('Fecha Registro:');
				$textRun->getFont()->setBold(true)
				->setSize(16)
				->setColor(new Color(Color::COLOR_RED));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(300)
				->setOffsetX(645)
				->setOffsetY(375);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun(date("d-m-Y",strtotime($fotos[$i]["Fecha_Registro"])));
				$textRun->getFont()->setBold(true)
				->setSize(16)
				->setColor(new Color(Color::COLOR_BLACK));


				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(300)
				->setOffsetX(645)
				->setOffsetY(420);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun('Pregunta:');
				$textRun->getFont()->setBold(true)
				->setSize(16)
				->setColor(new Color(Color::COLOR_RED));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(300)
				->setOffsetX(645)
				->setOffsetY(445);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun($fotos[$i]["NombrePregunta"]);
				$textRun->getFont()->setBold(true)
				->setSize(16)
				->setColor(new Color(Color::COLOR_BLACK));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(300)
				->setOffsetX(645)
				->setOffsetY(490);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun('Local:');
				$textRun->getFont()->setBold(true)
				->setSize(16)
				->setColor(new Color(Color::COLOR_RED));

				$parrafo = $currentSlide->createRichTextShape()
				->setWidth(300)
				->setOffsetX(645)
				->setOffsetY(515);
				$parrafo->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
				$textRun = $parrafo->createTextRun($fotos[$i]["NombreLocal"]);
				$textRun->getFont()->setBold(true)
				->setSize(16)
				->setColor(new Color(Color::COLOR_BLACK));


				$currentSlide->addShape($oShape);


				$oBkgImage = new Image();
				$oBkgImage->setPath(realpath('.') . '\PNG\fondo_audisis.png');
				$currentSlide->setBackground($oBkgImage);
			
		}


	    $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
	    header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation; charset=UTF-8');
	    header('Content-Disposition: attachment;filename="'.$logo['NombreFormulario'].'.pptx"');
	    header('Cache-Control: max-age=0'); 
	    $oWriterPPTX->save('php://output');
		
	}

}

?>