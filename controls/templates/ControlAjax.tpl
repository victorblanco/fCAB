<!-- @ LOADING @ -->
	$("<!-- {divLoading} -->").ajaxStart(
				  function inicioEnvio(){ $("<!-- {divLoading} -->").html(<!-- {loading} -->) });
<!-- @ LOADING @ -->
<!-- @ LOADING2 @ -->
	$("<!-- {divResponse} -->").html(html);
<!-- @ LOADING2 @ -->

<script language="javascript">
//CREATE POR CONTROLAJAX
$(document).ready(register<!-- {name} -->);
function register<!-- {name} -->(){
	try{
		$("<!-- {disparador} -->").<!-- {event} -->(function (e) {
			e.preventDefault();
			
			<!-- {function_ini} -->
			<!-- {loading_} -->			
			
			$.ajax({
				url: <!-- {url} -->,
				cache: false,
				type: "<!-- {type} -->",
				<!-- {extra} -->
				scriptCharset: "utf-8",
				contentType: "application/x-www-form-urlencoded",
				error: function (xhr, ajaxOptions, thrownError) {
				    alert(xhr.statusText);
				    alert(xhr.responseText);
				    alert(xhr.status);
				    alert(thrownError);

				},
				success: function(html){ 
					$("<!-- {response} -->").html(html);
					<!-- {function_fin} -->		
				}
			});
			return false;
		});
	}catch(e){alert(e);}
}</script>
