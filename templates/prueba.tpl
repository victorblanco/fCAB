<html>
	<head>
	<script language="javascript" src="/victor/core/js/jquery.js"></script>
		<script language="javascript" >
		$(document).ready(register);
		$(document).ready(registerTexto);

		function register(){
		try{
		$(".pepe").click(function () {
			 $("#contentAjax").ajaxStart(
				  function inicioEnvio(){ $("#contentAjax").html("Cargando") });
			
			 $.ajax({
					 url: "/victor/core/app/Prueba.ejemplo",
					 cache: false,
					 scriptCharset: "utf-8",
					 dataType: "text/html",
					 contentType: "application/x-www-form-urlencoded",
					  error: function(objeto, quepaso, otroobj){
							 //alert("Estas viendo esto por que fallé;
							 alert("Pasó siguiente: "+quepaso);
							 },
					 success: function(html){ $("#contentAjax").html(html);}
			 });
		}); 
		}
		catch(e){
			
		}
		}
		//segundo ejemplo
		function registerTexto(){
		try{
		$(".btn").click(function () {
			 $("#contentAjax").toggle();
			 $("#contentAjax").ajaxStart(
				  function inicioEnvio(){ $("#contentAjax").html("Cargando") });
			
			 $.ajax({
					 url: "/victor/core/app/Prueba.ejemplo",
					 cache: false,
					 data:$("#formulario1").serialize(),
					 scriptCharset: "utf-8",
					 dataType: "text/html",
					 contentType: "application/x-www-form-urlencoded",
					  error: function(objeto, quepaso, otroobj){
							 //alert("Estas viendo esto por que fallé;
							 alert("Pasó siguiente: "+quepaso);
							 },
					 success: function(html){ 
					$("#contentAjax").fadeOut("slow");
					 	$("#contentAjax").html(html);}
			 });
		
		});   
		}catch(e){alert(e);}
			
		}</script>
	</head>
	<body>
		<div style="background: #CCCCCC" width="100px" height="100px" id="contentAjax"></div>
		<h1 class="pepe">hola</h1>
		<input type="button" class="btn"/>
		<form action="victor/core/app/Prueba.ejemplo" name="formulario" id="formulario1">
			<input type="text" name="hola" value="" id="texto"/>
		</form>
	</body>
</html>
