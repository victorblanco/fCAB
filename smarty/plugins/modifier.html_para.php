<?php
/*
* Smarty plugin
*
-------------------------------------------------------------
* File: modifier.html_para.php
* Type: modifier
* Name: html_para
* Version: 1.0
* Date: June 19th, 2003
* Purpose: Cut a string preserving any tag nesting and matching.
* Install: Drop into the plugin directory.
* Author: Original Javascript Code: Benjamin Lupu <lupufr@aol.com>
* Translation to PHP & Smarty: Edward Dale <scompt@scompt.com>
* Modification to add a string: Sebastian Kuhlmann <sebastiankuhlmann@web.de>
*
-------------------------------------------------------------
*/
function smarty_modifier_html_para($string, $beg=true)
{

$buscar1=strpos($string,"<br/>");$buscar2=strpos($string,"<br/>")+5;
if ($buscar1===false) {$buscar1=strpos($string,"<br>");$buscar2=strpos($string,"<br>")+4;}
if ($buscar1===false) {$buscar1=strpos($string,"<BR>");$buscar2=strpos($string,"<BR>")+4;}
if ($buscar1===false) {$buscar1=strpos($string,"<BR/>");$buscar2=strpos($string,"<BR/>")+5;}
if ($buscar1===false) {$buscar1=strpos($string,"</p>")+4;$buscar2=strpos($string,"</p>")+4;}
if ($buscar1===false) {$buscar1=strpos($string,"</P>")+4;$buscar2=strpos($string,"</P>")+4;}
if ($buscar1===false) {$buscar1=50; $buscar2=50;}

if ($beg)
  return substr($string,0,$buscar1);
else
  return substr($string,$buscar2);

//strstr($string,"<br/>",false);

$addstring = " " . $addstring;

if (strlen($string) > $length) {
if( !empty( $string ) && $length>0 ) {
$isText = true;
$ret = "";
$i = 0;

$currentChar = "";
$lastSpacePosition = -1;
$lastChar = "";

$tagsArray = array();
$currentTag = "";
$tagLevel = 0;

$noTagLength = strlen( strip_tags( $string ) );

// Parser loop
for( $j=0; $j<strlen( $string ); $j++ ) {

$currentChar = substr( $string, $j, 1 );
$ret .= $currentChar;

// Lesser than event
if( $currentChar == "<") $isText = false;

// Character handler
if( $isText ) {

// Memorize last space position
if( $currentChar == " " ) { $lastSpacePosition = $j; }
else { $lastChar = $currentChar; }

$i++;
} else {
$currentTag .= $currentChar;
}

// Greater than event
if( $currentChar == ">" ) {
$isText = true;

// Opening tag handler
if( ( strpos( $currentTag, "<" ) !== FALSE ) &&
( strpos( $currentTag, "/>" ) === FALSE ) &&
( strpos( $currentTag, "</") === FALSE ) ) {

// Tag has attribute(s)
if( strpos( $currentTag, " " ) !== FALSE ) {
$currentTag = substr( $currentTag, 1, strpos( $currentTag, " " ) - 1 );
} else {
// Tag doesn't have attribute(s)
$currentTag = substr( $currentTag, 1, -1 );
}

array_push( $tagsArray, $currentTag );

} else if( strpos( $currentTag, "</" ) !== FALSE ) {
array_pop( $tagsArray );
}

$currentTag = "";
}

if( $i >= $length) {
break;
}
}

// Cut HTML string at last space position
if( $length < $noTagLength ) {
if( $lastSpacePosition != -1 ) {
$ret = substr( $string, 0, $lastSpacePosition );
} else {
$ret = substr( $string, $j );
}
}

// Close broken XHTML elements
while( sizeof( $tagsArray ) != 0 ) {
$aTag = array_pop( $tagsArray );
$ret .= "</" . $aTag . ">\n";
}

} else {
$ret = "";
}

// only add string if text was cut
if ( strlen($string) > $length ) {
return( $ret.$addstring );
}
else {
return ( $res );
}
}
else {
return ( $string );
}
}

/* vim: set expandtab: */

?>