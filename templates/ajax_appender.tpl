<!-- @ SIGUIENTE_APPEND @ --><!-- #ver_mas# --><!-- @ SIGUIENTE_APPEND @ -->
<!-- @ LINK_APPEND @ -->
	<a onmouseout="document.getElementById('img_more_activity').src='img/flecha_azul_sur.png'" onmouseover="document.getElementById('img_more_activity').src='img/flecha_naranja_sur.png'" onclick="appendPagination<!-- {function_prefix} -->('<!-- {txt_sanitized} -->');" style="cursor: pointer;"><img id="img_more_activity"  src="img/flecha_azul_sur.png">&nbsp;&nbsp;<input type="hidden" id="ajax_paginator_action_<!-- {function_prefix} --><!-- {txt_sanitized} -->" value="<!-- {url} -->"/><!-- {txt} --></a>
<!-- @ LINK_APPEND @ -->
<!-- @ LINK_UPDATE @ -->
	<div style="float: right;"><a onclick="updateContent<!-- {function_prefix} -->('<!-- {txt} -->');" style="cursor: pointer;"><img onmouseout="this.src='img/update_off.png'" onmouseover="this.src='img/update_on.png'" alt="<!-- {txt} -->" title="<!-- {txt} -->" src="img/update_off.png">&nbsp;&nbsp;<input type="hidden" id="ajax_paginator_update_<!-- {txt} -->" value="<!-- {url} -->"/></a></div>
<!-- @ LINK_UPDATE @ -->
<!-- @ UPDATE @ --><!-- #actualizar# --><!-- @ UPDATE @ -->
<!-- @ JS @ -->
<script type="text/javascript">

/*$(window).scroll(function (){
	if($(window).scrollTop() == $(document).height() - $(window).height()){
		//appendPagination();
		//alert($(".demo").attr("style"));
		//if(){alert("yea");}else{alert("nou");}
	}
	
});*/

function updateContent<!-- {function_prefix} -->(txt){
	params = document.getElementById('ajax_paginator_update_<!-- {function_prefix} -->'+txt).value;
	
	$("#<!-- {list_container} -->").fadeOut();
	$.post("app/<!-- {controller} -->"+params, function(data){
			//sleep(1000);
			newdata = eval('('+data+')');
			$("#<!-- {list_container} -->").html(newdata[0]);
			$("#<!-- {pagination_container} -->").html(newdata[1]);
			$("#<!-- {list_container} -->").fadeIn();
	
		});
}

function appendPagination<!-- {function_prefix} -->(txt){
	params = document.getElementById('ajax_paginator_action_<!-- {function_prefix} -->'+txt).value;
	$("#<!-- {pagination_container} -->").html('<!-- {div_loading} -->');
//	cargando("#<!-- {pagination_container} -->");//.addClass("background-grey");
	$.post("app/<!-- {controller} -->"+params, function(data){
			//sleep(1000);
			newdata = eval('('+data+')');
			$("#<!-- {list_container} -->").fadeOut();
			$("#<!-- {list_container} -->").<!-- {type} -->(newdata[0]);
			$("#<!-- {pagination_container} -->").html(newdata[1]);
			$("#<!-- {list_container} -->").fadeIn();
		});
}
</script>
<!-- @ JS @ -->
<!-- @ APPEND @ -->
<div style="text-align: left;float: left; padding: 5px 10px;"><!-- {links} --></div>
<!-- @ APPEND @ -->

<!-- @ ANTERIOR_HTML @ -->&lt;<!-- @ ANTERIOR_HTML @ -->
<!-- @ SIGUIENTE_HTML @ -->&gt;<!-- @ SIGUIENTE_HTML @ -->
<!-- @ INICIAL_HTML @ -->&lt;&lt;<!-- @ INICIAL_HTML @ -->
<!-- @ FINAL_HTML @ -->&gt;&gt;<!-- @ FINAL_HTML @ -->
<!-- @ NOLINK_HTML @ -->
	<font class="diffuse-text"><!-- {txt} --></font>
<!-- @ NOLINK_HTML @ -->
<!-- @ RESALTADO @ -->
	<b><!-- {txt} --></b>
<!-- @ RESALTADO @ -->
<!-- @ SEPARATOR @ -->&nbsp;<!-- @ SEPARATOR @ -->
<!-- @ LINK_HTML @ -->
	<input type="hidden" id="ajax_paginator_action_<!-- {function_prefix} --><!-- {txt_sanitized} -->" value="<!-- {url} -->"/><a  onclick="appendPagination<!-- {function_prefix} -->('<!-- {txt_sanitized} -->');" style="cursor: pointer;"><!-- {txt} --></a>
<!-- @ LINK_HTML @ -->
<!-- @ HTML @ -->
<div style="text-align: left; float: left;padding-left: 3px; width: 33%;"><!-- #pagina# -->&nbsp;<span class="marked-text"><b><!-- {pagina} --></b></span>&nbsp;<!-- #de# -->&nbsp;<span class="marked-text"><b><!-- {total} --></b></span>&nbsp;</div><div style="text-align: center; float: left;width: 30%;" id="cargando"></div><div style="text-align: right;float: right; width: 34%;"><!-- {links} --></div>
<!-- @ HTML @ -->
