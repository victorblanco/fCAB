<!-- @ COLUMN_MODEL @ -->,{name:'<!-- {name} -->',index:'<!-- {index} -->', sortable: <!-- {sortable} -->, resizable: <!-- {resizable} -->, align: '<!-- {align} -->' <!-- {formatter} -->}<!-- @ COLUMN_MODEL @ -->
<!-- @ COLUMN_NAME @ -->,'<!-- {name} -->'<!-- @ COLUMN_NAME @ -->
<!-- @ DATE_FORMATER @ -->
,sorttype:'date',formatter:'date', formatoptions:{srcformat:"Y-m-d",newformat:"d-M-Y"}
<!-- @ DATE_FORMATER @ -->
<!-- @ FIELD_FORMATTER @ -->
, formatter: fieldFormatter<!-- {name} -->
<!-- @ FIELD_FORMATTER @ -->
<!-- @ FIELD_FORMATTER_FUNCTION @ -->
function fieldFormatter<!-- {name} -->(cellvalue, options, rowObject){
	var value;
	
	switch(cellvalue){
		<!-- {cases} -->
		default:
			value = '<!-- #unknown# -->'; 
	}
	
	return value;
}
<!-- @ FIELD_FORMATTER_FUNCTION @ -->
<!-- @ FIELD_FORMATTER_FUNCTION_CASE @ -->
		case '<!-- {key} -->':
			value = '<!-- {value} -->';
			break;
<!-- @ FIELD_FORMATTER_FUNCTION_CASE @ -->

<script type="text/javascript">

document.onkeydown = checkKeycode
function checkKeycode(e) {
	var keycode;
	if (window.event) 
		keycode = window.event.keyCode;
	else if (e) 
		keycode = e.which;

	if (keycode == 13){
		buscar();
	}
}

jQuery(document).ready(function(){
	jQuery("#admin").jqGrid({
	    sortable: true, 
	    method: "post",
	    url:'app/Admin.getList?TABLE=<!-- {idTable} --><!-- {params} -->&nd='+new Date().getTime(),
	    datatype: "json",
	    colNames:[<!-- {col_names} -->],
	    colModel:[
	  	        <!-- {col_models} -->
	    ],
	    pager: '#ptoolbar', 
		altRows:true,
	    rowNum:20,
	    rowList:[10,20,30],
	    sortname: '<!-- {index} -->',
	    viewrecords: true,
	    sortorder: "asc",
	    caption: "<!-- {title} -->",
	    height:<!-- {height} -->,
	    autowidth: true,
	    onSelectRow: function(id){
		    var params = "";
		    var valores;
		    var splitted_id = id.split("|");
		    
		    for( indice in splitted_id ){
			    if(splitted_id[indice] != ""){
			    	valores = splitted_id[indice].split(":");
			    	params = params + "&"+valores[0]+"="+valores[1];
			    }
		    }
		  	//alert("app/Admin.detail?TABLE=<!-- {idTable} -->"+params);
		    window.location = "app/Admin.detail?TABLE=<!-- {idTable} --><!-- {params} -->"+params;
		    
		} 
    
	});
$("#admin").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false}); 
//	$("#admin").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true}); 

});

function buscar(){
	cad = $('#formulario').serialize();
	$('#admin').jqGrid('setGridParam',{url:"app/Admin.getList?TABLE=<!-- {idTable} -->&"+cad}).trigger("reloadGrid") ;
	 return false
}

<!-- {formatter_functions} -->

</script>

	<div>
		<div class="admin_header">
			<div style="float: left; width: 50%; font-weight: bold;">&nbsp;</div>
			<div style="float: left; width: 50%; text-align: right;">
				<a href="app/Admin.detail?TABLE=<!-- {idTable} --><!-- {params} -->" /><img src="img/admin/new.png" border="0" /></a> &nbsp;
				<a onclick="buscar();" /><img src="img/admin/search.png" border="0" style="cursor: pointer;" /></a> &nbsp;
			</div>
		</div>
		<div class="admin_content">
			<form name="formulario" id="formulario" method="post" onsubmit="return buscar()">
				<table style="width: 100%">
					<tr><!-- {header} --></tr>
				</table>
			</form>
			<div id="cuerpo2">
				<div id="columna1">
	      			<div id="listado">
						<table id="admin"></table> 
						<div id="ptoolbar" ></div>
					</div>
				</div>
			</div>
		</div>
	</div>


