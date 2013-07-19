<!-- @ BUSCADOR @ -->
	<div id="ajax-container" style="width: 100%">
		<!-- {cont} -->
	</div>
	<div id="ajax-footer"><!-- {paginador} --></div>
<!-- @ BUSCADOR @ -->
<!-- @ BUSCADOR_BOX @ -->
		<table style="width: 100%">
			<tr>
				<!-- {columnas} -->
			</tr>
		
			<!-- {items} -->
		</table>
<!-- @ BUSCADOR_BOX @ -->
<!-- @ ITEMS_BUSCADOR @ -->
<tr>
	<td class="fondo_buscador_admin"><span style="cursor: pointer" onclick="getValue<!-- {campo} -->('<!-- {value_esc} -->')"><!-- {value} --></span></td>
</tr>
<!-- @ ITEMS_BUSCADOR @ -->
<!-- @ ITEMS_BUSCADOR_COLUM @ -->
<td><!-- {columna} --></td>
<!-- @ ITEMS_BUSCADOR_COLUM @ -->
<!-- @ NUEVO_ELEMENTO @ --><!-- #nuevo_elemento# --><!-- @ NUEVO_ELEMENTO @ -->
<!-- @ BOTONERA @ --><!-- {unidades} --><!-- @ BOTONERA @ -->
<!-- @ BOTONERA_UNIDAD @ -->
<a href="<!-- {url} --><!-- {params} -->"><img src="<!-- {icono} -->" border="0" alt="<!-- {caption} -->" title="<!-- {caption} -->" /></a>
<!-- @ BOTONERA_UNIDAD @ -->
<!-- @ SELECT_OPTION @ -->
	<option value="<!-- {value} -->"><!-- {description} --></option>
<!-- @ SELECT_OPTION @ -->
<!-- @ SELECT @ -->
	<select name="<!-- {campo} -->" class="formulario <!-- {claseValidador} -->">
	</select>
<!-- @ SELECT @ -->
<!-- @ SELECT_BUSQUEDA @ -->
<script>
	function getValue<!-- {campo} -->( value ){
		$("#<!-- {campo} -->_busqueda").attr("value", value);
		$("#<!-- {campo} -->_dialog").dialog("close");
		$(".searchAdmin").val("");
		
	}
	$(document).ready(function(){
		$("#<!-- {campo} -->_dialog").dialog({
				resizable: true,
				height:370,
				width: 452,
				modal: true,
				autoOpen: false
		});
		$("#<!-- {campo} -->_busqueda").focus(function(){
			
			openBuscador();
			 $("#<!-- {campo} -->_dialog").dialog("open");
		});

	});

	function openBuscador(){
		 $.ajax({
             type: 'POST',
             url: 'app/Admin.busqueda',
             data:  {"id_campo": "<!-- {id_campo} -->", "idSearchAdmin" : "<!-- {value} -->"},
                            
             success: function(data){
			 	$("#<!-- {campo} -->_dialog_cont").html(data); 
			 	
             },
             error: function(data){
                     return "false";
             }
     	});
	}

	function cargando(){
	}

	function setFilter(value){
		$.post("app/Admin.rpcSearch?id_campo=<!-- {id_campo} -->&searchAdmin=" + value , function(data){
			newdata = eval('('+data+')');
			$("#ajax-container").html(newdata[0]);
			$("#ajax-footer").html(newdata[1]);
		});

	}
		
	
</script>
	<div id="<!-- {campo} -->_dialog" title="<!-- #buscador# -->">
		<div style="width:  95%; text-align: center;">
			<a onclick="getValue<!-- {campo} -->('')" style="cursor:pointer"><!-- #valor_vacio# --></a>
			<input type="text"  name="searchAdmin" class="formulario searchAdmin" onkeyup="setFilter(this.value)"/>
		</div>
		<div id="<!-- {campo} -->_dialog_cont">
		
		</div>
	</div>
	<input type="text" readonly="readonly" name="<!-- {campo} -->" value="<!-- {value} -->"  class="formulario search_field <!-- {claseValidador} -->" id="<!-- {campo} -->_busqueda" /> 
<!-- @ SELECT_BUSQUEDA @ -->
<!-- @ TEXT @ -->
	<input type="text" id="<!-- {campo} -->" name="<!-- {campo} -->" value="<!-- {value} -->" class="formulario <!-- {claseValidador} -->" />
<!-- @ TEXT @ -->
<!-- @ PASSWORD @ -->
	<input type="password" id="<!-- {campo} -->" title="<!-- {title} -->" name="<!-- {campo} -->" value="" class="formulario <!-- {claseValidador} -->" /></td></tr>
	<tr>
		<td class="label" nowrap="nowrap" width="25%"><!-- #confirma_pass# --></td>
		<td width="75%"><input type="password" class="formulario :same_as;<!-- {campo} --> :only_on_blur" />
<!-- @ PASSWORD @ -->
<!-- @ CHECK @ -->
	<input type="checkbox" <!-- {activo} --> name="<!-- {campo} -->" value="<!-- {value} -->" class="formulario <!-- {claseValidador} -->" />
<!-- @ CHECK @ -->
<!-- @ LABEL @ -->
	<!-- {value} -->
<!-- @ LABEL @ -->
<!-- @ DATE @ -->
	<script>
	$(function() {
		$( "#<!-- {campo} -->" ).datepicker();
	});
	</script>
	
	<input type="text" id="<!-- {campo} -->" name="<!-- {campo} -->" value="<!-- {value} -->" class="formulario <!-- {claseValidador} -->"/>
<!-- @ DATE @ -->
<!-- @ DATETIME @ -->
	<script>
	$(function() {
		$( "#<!-- {campo} -->" ).datetimepicker();
	});
	</script>
	
	<input type="text" id="<!-- {campo} -->" name="<!-- {campo} -->" value="<!-- {value} -->" class="formulario <!-- {claseValidador} -->"/>
<!-- @ DATETIME @ -->
<!-- @ FILE @ -->
	<!-- {preview} -->
	<input type="file" name="<!-- {campo} -->" value="<!-- {value} -->"  class="formulario <!-- {claseValidador} -->"/>
<!-- @ FILE @ -->
<!-- @ FILE_DETAIL @ -->
	<span id="<!-- {campo} -->enlace"><a href="<!-- {value} -->" target="_blank" id="<!-- {campo} -->"><!-- {value} --></a></span>
<!-- @ FILE_DETAIL @ -->
<!-- @ FILE_PREVIEW @ -->
	<!-- {preview} -->
	<input type="file" name="<!-- {campo} -->" value=""  class="formulario <!-- {claseValidador} -->" />
<!-- @ FILE_PREVIEW @ -->
<!-- @ FILE_PREVIEW_DETAIL @ -->
<span id="<!-- {campo} -->imagen"><a onclick="getImage('<!-- {value} -->');" style="cursor: pointer;"><img id="<!-- {campo} -->" src="img/imagen_resizable.php?img=../<!-- {value} -->&imgTam=avatar&t=c" alt="<!-- {value} -->" title="<!-- {value} -->"/></a></span>
<!-- @ FILE_PREVIEW_DETAIL @ -->
<!-- @ READ @ -->
	<input id="<!-- {campo} -->" type="text" readonly class="formulario <!-- {claseValidador} -->" style='background: url("img/admin/bg-form-field-readonly.gif") repeat-x scroll left top #FFFFFF;' name="<!-- {campo} -->" value="<!-- {value} -->"  />
<!-- @ READ @ -->
<!-- @ TEXTAREA @ -->
	<textarea cols="<!-- {cols} -->" rows="<!-- {rows} -->" name="<!-- {campo} -->" class="formulario <!-- {claseValidador} -->"><!-- {value} --></textarea>
<!-- @ TEXTAREA @ -->
<!-- @ TEXTAREA_EDITOR @ -->
	<textarea cols="<!-- {cols} -->" rows="<!-- {rows} -->" name="<!-- {campo} -->" id="id_<!-- {campo} -->" class="formulario <!-- {claseValidador} -->"><!-- {value} --></textarea>
	<script>
	$(document).ready(function(){

		$("#id_<!-- {campo} -->").cleditor();
	});
	
</script>
<!-- @ TEXTAREA_EDITOR @ -->
<!-- @ HIDDEN @ -->
	<input type="hidden" name="<!-- {campo} -->" value="<!-- {value} -->" />
<!-- @ HIDDEN @ -->
<!-- @ CAMPO @ -->
	<tr>
		<td class="label" nowrap="nowrap" width="25%"><!-- {etiqueda} --></td>
		<td width="75%"><!-- {valor} --></td>
	</tr>
<!-- @ CAMPO @ -->
<!-- @ COLUMNAS @ -->
	<td valign="top" width="<!-- {width} -->%">
		<table width="100%">
			<!-- {campos} -->
		</table>
	</td>
<!-- @ COLUMNAS @ -->
<!-- @ FUNCION_ELIMINAR @ -->

function confirmaEliminar(){
	return confirm("<!-- #eliminar_entrada# --> '<!-- {descriptor} -->'?");
}
<!-- @ FUNCION_ELIMINAR @ -->
<!-- @ BOTON_ELIMINAR @ --><a onclick="return confirmaEliminar();" href="app/Admin.delete?TABLE=<!-- {TABLE} --><!-- {params} --><!-- {url_pk} -->" ><img src="img/admin/delete.png" border="0" alt="<!-- #borrar_entrada# -->" title="<!-- #borrar_entrada# -->"/></a> &nbsp;<!-- @ BOTON_ELIMINAR @ -->
<!-- @ BOTON_ELIMINAR_MSIE @ --><input type="button" onclick="if(confirmaEliminar()) window.location = \'app/Admin.delete?TABLE=<!-- {TABLE} --><!-- {params} --><!-- {url_pk} -->\';" value="<!-- #borrar_entrada# -->"/> &nbsp;<!-- @ BOTON_ELIMINAR_MSIE @ -->
<!-- @ BOTON_NUEVO @ -->
<a href="app/Admin.detail?TABLE=<!-- {TABLE} --><!-- {params} -->" /><img src="img/admin/new.png" border="0" alt="<!-- #crear_registro# -->" title="<!-- #crear_registro# -->"/></a> &nbsp;
<!-- @ BOTON_NUEVO @ -->
<!-- @ FORMULARIO_AJAX @ -->
$(document).ready(function() { 
	var options = { 
	        beforeSubmit:  openCargando,  // pre-submit callback 
	        success:       function(data) {
        						if (data.validation_failed) {
							        Vanadium.decorate(data.validation_failed);
							         return false;
							    }else
							   		showResponse(data);
							}
	    }; 
    $('#formulario').ajaxForm(options); 
   
    
}); 

function openCargando(){
	$("#boton_guardar").attr("src","img/admin/loading.gif");
}

function showResponse(responseText){
	var new_data = eval("("+responseText+")");

	for(campo in new_data){
		$("#"+campo).attr("value",new_data[campo].innerHTML());
		$("#"+campo+"imagen").html('<a onclick="getImage(\''+new_data[campo]+'\');" style="cursor: pointer;"><img src="img/imagen.php?imgRuta=../&img='+new_data[campo]+'&xMax=100" alt="'+new_data[campo]+'" title="'+new_data[campo]+'"/></a>');
		$("#"+campo+"enlace").html("<a href='"+new_data[campo]+"' target='_blank'>"+new_data[campo]+"</a>");
	}

	$("#boton_guardar").attr("src","img/admin/save.png");
	$("#response").html('<span style="color: green;"><!-- #operacion_exito# --></span>');
	$("#response").fadeIn("slow");
	setTimeout('$("#response").fadeOut("slow");',3000);
}
<!-- @ FORMULARIO_AJAX @ -->
<script type="text/javascript">


$(document).ready(function(){
	/*if($.browser.msie()){
		$("#gen-adm-buttons").html('<input type="button" onclick="window.location = \'app/Admin.list?TABLE=<!-- {TABLE} --><!-- {params} -->&_filter_adm=1\';" value="<!-- #volver_listado# -->"/>'+
				' &nbsp;<input type="submit" id="boton_guardar" class="submit" value="<!-- #guardar# -->" />&nbsp;'+
				'<!-- {boton_eliminar_msie} -->');
	}else{*/
	/*if (navigator.appName=="Microsoft Internet Explorer"){
		$("#gen-adm-buttons").html('<input type="button" onclick="window.location = \'app/Admin.list?TABLE=<!-- {TABLE} --><!-- {params} -->&_filter_adm=1\';" value="<!-- #volver_listado# -->"/>'+
				' &nbsp;<input type="submit" id="boton_guardar" class="submit" value="<!-- #guardar# -->" />&nbsp;'+
				'<!-- {boton_eliminar_msie} -->');	
	}else{
		$("#gen-adm-buttons").html('<a href="app/Admin.list?TABLE=<!-- {TABLE} --><!-- {params} -->&_filter_adm=1" ><img src="img/admin/list.png" border="0" alt="<!-- #volver_listado# -->" title="<!-- #volver_listado# -->" /></a> &nbsp;<button id="boton_guardar" class="submit" style="border:0px; background: none; cursor: pointer;"><img src="img/admin/save.png" alt="<!-- #guardar# -->" title="<!-- #guardar# -->" /></button> &nbsp;<!-- {boton_eliminar} -->');
	}*/
	 $( "input:button" ).button();
});

//Inicializaci�n del validador
jQuery(document).ready(function() {
	if (typeof (VanadiumConfig) === "object" && VanadiumConfig) {
		Vanadium.each(VanadiumConfig, function(b, a) {
			Vanadium.config[b] = a
		})
	}
	if (typeof (VanadiumRules) === "object" && VanadiumRules) {
		Vanadium.each(VanadiumRules, function(b, a) {
			Vanadium.rules[b] = a
		})
	}
	Vanadium.init()
});
<!-- {formulario_ajax} -->

<!-- {funcion_eliminar} -->


$(document).ready(function() {
	
	$( "#imagen_dialog" ).dialog({
		width: '500px',
		modal: true,
		resizable: false,
		autoOpen: false,
		buttons: {
			"Cerrar": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});

function getImage(image){
	$("#imagen_dialog").dialog("open");
	$("#imagen_dialog").html("<center><img src='img/imagen_resizable.php?imgRuta=../&img="+image+"' alt='"+image+"' title='"+image+"' border='0'/></center>");
}

</script>
<div id="imagen_dialog" title="Imagen"></div>
<div>
<form action="app/Admin.save" name="formulario" id="formulario" method="post"  enctype="multipart/form-data" >
	<input type="hidden" name="TABLE" value="<!-- {TABLE} -->" />
	<div class="admin_header">
		<div id="gen-adm-buttons" style="clear: both; float: left; width: 50%">
		
		<a href="app/Admin.list?TABLE=<!-- {TABLE} --><!-- {params} -->&_filter_adm=1" ><img src="img/admin/list.png" border="0" alt="<!-- #volver_listado# -->" title="<!-- #volver_listado# -->" /></a> 
		<input type="submit"  style="background: url(img/admin/save.png) center no-repeat ; border:0px; height: 32px; width: 32px; vertical-align: top;" value="" > 
		&nbsp;<!-- {boton_eliminar} -->
		</div>
		<div style="float: left; width: 50%; text-align: right;">
			
			<!-- {boton_nuevo} -->
			<!-- {botonera} -->
		</div>
	</div>
	<div class="admin_content">
	<div id="response" class="op_response_admin"></div>
	<table style="width: 100%;"> 
		<tr>
			<!-- {columnas} -->	
		</tr>
	</table>
	</div>
</form>
</div>