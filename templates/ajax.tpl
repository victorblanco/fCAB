<!-- @ LOADING @ -->
	$("<!-- {divLoading} -->").ajaxStart(
				  function inicioEnvio(){ $("<!-- {divLoading} -->").html(<!-- {loading} -->) });
<!-- @ LOADING @ -->
<!-- @ LOADING2 @ -->
	$("<!-- {divResponse} -->").html(html);
<!-- @ LOADING2 @ -->

<script language="javascript">
//CREATE POR CONTROLAJAX
function register<!-- {name} -->(){
	try{
		$("<!-- {disparador} -->").<!-- {event} -->(function () {
			<!-- {effectDivLoading} -->
			<!-- {loading_} -->			
			$.ajax({
			 	url: <!-- {url} -->,
		 		cache: false,
		 		<!-- {extra} -->
		 		scriptCharset: "utf-8",
		 		dataType: "text/html",
			 	contentType: "application/x-www-form-urlencoded",
			  	error: function(objeto, quepaso, otroobj){
					alert("Pasó siguiente: "+quepaso);
				},
		 		success: function(html){ 
		 		<!-- {effectDivLoading2} -->
		 		
				$(<!-- {divResponse} -->).html(html);		
		 		}
			});
		
		});
	}catch(e){alert(e);}
		
}</script>