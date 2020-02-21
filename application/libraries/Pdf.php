<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "fpdf/fpdf.php";

class PDF extends FPDF{
	 public function __construct() {
            parent::__construct();
   }

    public function Header(){
            $this->Image('assets/img/logo-progestion.png',10,8,30);
            $this->SetFont('Arial','B',12);
            $this->Cell(30);
            $this->Ln(7);
    }


    public function Footer(){
           // $this->SetY(-15);
           // $this->SetFont('Arial','I',8);
           // $this->Cell(0,10,utf8_decode('Página '.$this->PageNo()),0,0,'C');
    }



   public function celda($w,$h,$x,$t,$color){
        $height=$h/3;
        $first=$height+2;
        $len=strlen($t);
        if($len>32){
          $txt=str_split($t,32);
          for ($i=0; $i < count($txt) ; $i++) { 
            $this->SetX($x);
            $this->Cell($w,$first,$txt[$i],'','','');
            $first+=($height*2)+2;
          }
          $this->SetX($x);
          $this->Cell($w,$h*2,'',1,0,'C',$color);
        } else {
          $this->SetX($x);
          $this->Cell($w,$h*2,$t,1,0,'C',$color);
        }
    }


     public function celdagastos($w,$h,$x,$t,$color){
       $height=$h/3;
        $first=$height+2;
        //$second=$height+$height+$height+3;
        $len=strlen($t);
        if($len>35){
        $txt=str_split($t,35);          
          for ($i=0; $i < count($txt) ; $i++) { 
            $this->SetX($x);
            $this->Cell($w,$first,$txt[$i],'','','');
            $first+=($height*2);
          }
          $this->SetX($x);
          $this->Cell($w,$h*2.5,'',1,0,'C',$color);
        } else {
          $this->SetX($x);
          $this->Cell($w,$h*2.5,$t,1,0,'C',$color);
        }
      
    }

     public function celdadetgasto($w,$h,$x,$t,$color){
       $height=$h/3;
        $first=$height+2;
        //$second=$height+$height+$height+3;
        $len=strlen($t);
        if($len>35){
        $txt=str_split($t,35);          
          for ($i=0; $i < count($txt) ; $i++) { 
            $this->SetX($x);
            $this->Cell($w,$first,$txt[$i],'','','');
            $first+=($height*2);
          }
          $this->SetX($x);
          $this->Cell($w,$h*2.5,'',1,0,'C',$color);
        } else {
          $this->SetX($x);
          $this->Cell($w,$h*2.5,$t,1,0,'C',$color);
        }
      
    }



     public function celdasolicitud($w,$h,$x,$t,$color){
       $height=$h/3;
        $first=$height+2;
        //$second=$height+$height+$height+3;
        $len=strlen($t);
        if($len>80){
        $txt=str_split($t,80);          
          for ($i=0; $i < count($txt) ; $i++) { 
            $this->SetX($x);
            $this->Cell($w,$first,$txt[$i],'','','');
            $first+=($height*2)+2;
          }
          $this->SetX($x);
          $this->Cell($w,$h*2,'',1,0,'C',$color);
        } else {
          $this->SetX($x);
          $this->Cell($w,$h*2,$t,1,0,'C',$color);
        }
      
    }
        



 
}