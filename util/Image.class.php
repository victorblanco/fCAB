<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


// Redimensionnement

// Classe principale
class Img{
   // Propit s de l'objet
   var $name; // nom de l'image source
   var $org;  // dossier d'origine
   var $ext;  // extension de l'image
   var $error;// Varaible pour les erreurs
   var $dest; // dossier de destination
   var $lpoint; // position du dernier point
   
   /* constructeur
   * retourne void (rien)
   */
   function doImg($name, $org, $dest){
      $this->name = (string) $name;
      $this->org = (string) $org;
      $this->dest = (string) $dest;
      $this->lpoint = $this->LastPoint();
      $this->ext = $this->GetExtension();
   }

   /* Rcup re la position du dernier point
   * retourne (int)
   */
   function LastPoint(){
      return strrpos($this->name, '.');
   }

   /* Rcup re l'extension du fichier
   * retourne (string)
   */
   function GetExtension(){
      return substr($this->name, $this->lpoint);
   }
   
   /* Retourne l'erreur si il en a une
   * retourne (string)
   */
   function Error(){
      if(!empty($this->error)){
         return $this->error();
      }
   }
}

// Classe Fille
class Image extends Img{
   // Propit s de l'objet
   var $suffix; // suffix  ajouter   l'image
   var $thb_name; // nom complet de l'image rduite
   var $size; // taille pour r duction
   var $quality; // quamit de l'image r duite
   var $name; // nom de l'image source
   var $org; // dossier d'origine de l'image
   var $dest; // dossier de destination
   
   /* constructeur
   * (string) nom
   * (string) $dossier d'origine
   * (string) dossier de destination
   * retourne void (rien)
   */
   function doImg($name, $org, $dest){
      $this->name = (string) $name;
      $this->dest = (string) $dest;
      $this->org = (string) $org;
      $this->lpoint = Img::LastPoint();
      $this->ext = Img::GetExtension();
   }
   
   /* Ajout des paramtres
   * (string) suffix de l'image
   * (int) taille (px)
   * (int) qualit  (%)
   * retourne void (rien)
   */
   function SetParam($suf,$size, $quality){
      $this->suffix = (string) $suf;
      $this->size = (int) $size;
      $this->quality = (int) $quality;
   }
   
   /* Ajout des paramtres s parament
   * (int) taille ($x)
   * retourne void (rien)
   */
   function SetSize($size){
      $this->size = (int) $size;
   }
   
   /* 
   * (int) Qualit (%)
   * retourne void (rien)
   */
   function SetQuality($quality){
      $this->quality = (int) $quality;
   }
   
   /*
   * (string) suffix
   * retourne void (rien)
   */
   function SetSuffix($suf){
      $this->suffix = (string) $suf;
   }
   
   /* 
   * r cupre le nom +chemin de l'image r sultante
   * retourne un (string)
   */
   function GetThbName(){
      $thb = substr($this->name, 0, Img::LastPoint());
      $thb.= $this->suffix.$this->ext;
      return $this->thb_name = $this->dest.$thb;
   }
   
   /* Lance le redimenssionnement
   * retourne un (bool)
   */
   function doThb(){
      if($this->Resize()){
         return true;
      }else{
         return false;
      }
   }
   
   /* Rcup re le nom + le chemin de l'image source
   * retourne void (rien)
   */
   function GetOrigine(){
      return $this->org.$this->name;
   }
   
   /*
   * Fonctions prives
   */
   
   /* Fonction de redimensionnement
   * * retourne un (bool)
   */
   function Resize(){   
      $source = $this->org.$this->name;
      $destination = $this->GetThbName();

      if (!file_exists($source)){
         $this->error = "Erreur : Le Fichier n'existe pas !";
      }
      if(!function_exists("Imagecreatefromjpeg")){
         $this->error = "Erreur : La Librairie GD n'est pas instal&eacute;e !";
      }
   
      switch($this->ext){
         case '.jpg':
         case '.jpeg':
		 case '.JPEG':
         case '.JPG':
            $src_img=imagecreatefromjpeg($source); 
            break;
         case '.png':
            $src_img=imagecreatefrompng($source); 
            break;
         case '.gif':
            $src_img=imagecreatefromgif($source); 
            break;
         default:
            $this->error = "Erreur: Extension non autoris&eacute;e";
            break;
      }
   
      if(!$src_img){
         $this->error = "Erreur : Lecture impossible de l'image ".$source." !";
      }
   
      //Taille de l'image originale
      $w = imagesx($src_img);
      $h = imagesy($src_img);
   	  //imagedestroy($src_img);
      //R cupre les proportions
      if($w<$h){
         $p = $w / $h;
         $height = $this->size;
         $width = $p * $height;
      }else{
         $p = $h / $w;
         $width = $this->size;
         $height = $p * $width;
      }
   	  
      $dst_img = ImageCreateTrueColor($width, $height);
      if(!$dst_img){
           $this->error = "Erreur : Buffer non cr&eacute;&eacute; : ".$dst_img;
       }
    
      imagecopyresampled($dst_img,$src_img,0,0,0,0,$width,$height,$w,$h);
	  imagedestroy($src_img);	
	  
       if(imagejpeg($dst_img,$destination,$this->quality)){
	   	  imagedestroy($dst_img);
		  unlink($source);
          return true;
       }else{
          return false;
		  unlink($source);
       }
   }   
}

//ini_set("memory_limit","100M");
/*
* Utilisation: redimenssioner sans  craser la source.
*/
//$dir = DIR_PUBLIC."img/casas/";
// instanciation de l'objet
//$thb = new MAYImg;
// appel du constructeur
// nim de la source: image.jpeg
// chemin source: ./ (dossier courant)
// destianation: ./ (dossier courant)
//$thb->doImg("IMG_0010.JPG", './', './');
// Config des parametres
// prefix: _thb
// taille du + grd cot 250px
// qualit  100%
//$thb->SetParam('_thb', 300, 60);
// pour connaitre le nom et chemin de l'image rduite
// r sultat: ./image_thb.jpeg
//$thumb = $thb->GetThbName();
// pour connaitre le nom et chemin de l'image d'origine
// rsultat: ./image.jpeg
//$source = $thb->GetOrigine();
// Lance le redimensionenemt
//$thb->doThb();

?>