<!-- @ IMG @ -->
<li><img alt="<!-- {alt} -->"  src="img/imagen.php?img=<!-- {ruta_img} -->&imgTam=detail" /></li> 
<!-- @ IMG @ -->
<script src="js/jquery.js" type="text/javascript"></script> 
<script src="js/jquery.easing.1.2.js" type="text/javascript"></script> 
<script src="js/jquery.slideviewer.1.1.js" type="text/javascript"></script> 
<script type="text/javascript"> 
    $(window).bind("load", function() { 
    $("div#mygalone").slideView() 
}); 
</script> 
<style>
/*preload classes*/ 
.svw {width: 150px; height: 20px; background: #fff;} 
.svw ul {position: relative; left: -999em;} 
 
/*core classes*/ 
.stripViewer {  
position: relative; 
overflow: hidden;  
border: 2px solid #E1E1E1;   
margin: 0 0 1px 0; 
} 
.stripViewer ul { /* this is your UL of images */ 
margin: 0; 
padding: 0; 
position: relative; 
left: 0; 
top: 0; 
width: 1%; 
list-style-type: none; 
} 
.stripViewer ul li {  
float:left; 
} 
.stripTransmitter { 
overflow: auto; 
width: 1%; 
} 
.stripTransmitter ul { 
margin: 0; 
padding: 0; 
position: relative; 
list-style-type: none; 
} 
.stripTransmitter ul li{ 
width: 20px; 
float:left; 
margin: 0 1px 1px 0; 
} 
.stripTransmitter a{ 
font: bold 10px Verdana, Arial; 
text-align: center; 
line-height: 22px; 
color: #000000; 
text-decoration: none; 
display: block; 
} 
.stripTransmitter a:hover, a.current{ 
background: #E1E1E1; 
color: #ff0000; 
} 
</style>
<div id="mygalone" class="svw"> 
    <ul> 
         <!-- {imgs} --> 
    </ul> 
</div> 