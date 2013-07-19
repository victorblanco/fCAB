<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<base href="<!-- {BASE} -->" />
	<title>Administración</title>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	 <script type="text/javascript">
	//The value should be equal to
	var trad_valorIgualA = '<!-- #admin_valor_igual_a# -->';
	//This is a required field.
	var trad_campoRequerido = '<!-- #admin_campo_requerido# -->';
	//Must be accepted!
	var trad_aceptar = '<!-- #admin_aceptar# -->';
	//Please enter a valid integer in this field.
	var trad_entero = '<!-- #admin_entero# -->';
	//Please enter a valid number in this field.
	var trad_numero = '<!-- #admin_numero# -->';
	//Please use numbers only in this field. please avoid spaces or other characters such as dots or commas.
	var trad_digitos = '<!-- #admin_digitos# -->';
	//"Please use letters only in this field."
	var trad_alpha = '<!-- #admin_alpha# -->';
	//"Please use ASCII letters only (a-z) in this field."
	var trad_alphaAZ = '<!-- #admin_alphaAZ# -->';
	//"Please use only letters (a-z) or numbers (0-9) only in this field. No spaces or other characters are allowed."
	var trad_alphanum = '<!-- #admin_alphanum# -->';
	
	//"Please enter a valid date."
	var trad_date = '<!-- #admin_date# -->';
	//"Please enter a valid email address. For example fred@domain.com ."
	var trad_email = '<!-- #admin_email# -->';
	//"Please enter a valid URL."
	var trad_url = '<!-- #admin_url# -->';
	//"Please use this date format: dd/mm/yyyy. For example 17/03/2006 for the 17th of March, 2006."
	var trad_date_au = '<!-- #admin_date_au# -->';
	//Please enter a valid $ amount. For example $100.00 .
	var trad_currency_dollar = '<!-- #admin_currency_dollar# -->';
	//"Please make a selection"
	var trad_selection = '<!-- #admin_selection# -->';
	//"Please select one of the above options."
	var trad_one_required = '<!-- #admin_one_required# -->';
	//"The value should be 
	var trad_length1 = '<!-- #admin_length1# -->';
	// characters long.
	var trad_length2 = '<!-- #admin_length2# -->';
	//"The value should be at least 
	var trad_min_length = '<!-- #admin_min_length# -->';
	//"The value should be at most
	var trad_max_length = '<!-- #admin_max_length# -->';
	//The value should be the same as 
	var trad_same_as1 = '<!-- #admin_same_as1# -->';
	//"There is no exemplar item!!!"
	var trad_same_as2 = '<!-- #admin_same_as2# -->';
	//The value should match the pattern
	var trad_format1 = '<!-- #admin_format1# -->';
	//provided parameter 
	var trad_format2 = '<!-- #admin_format2# -->';
	// is not valid Regexp pattern.
	var trad_format3 = '<!-- #admin_format3# -->';
	</script>
	<!-- CSS -->
<link href="css/admin.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/jqueryUI/jquery-ui.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/tinyTips.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.cleditor.css" rel="stylesheet" type="text/css" />

<!-- JS -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jqueryUI.js"></script>
	<script type="text/javascript" src="js/jquery.tinyTips.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="css/jqgrid/ui.jqgrid.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="css/jqgrid/my.jqgrid.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="css/vanadium.css" />
	<script src="js/jqgrid/grid.locale-es.js" type="text/javascript"></script>
	<script src="js/jqgrid/jquery.jqGrid.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.form.js"></script>
	<script type="text/javascript" src="js/vanadium-min.js"></script>
	
	<script type="text/javascript" src="js/jquerytimepicker.js"></script>   
	<script type="text/javascript" src="js/jquery.cleditor.min.js"></script>  

	</head>
	<body style="background: url('img/bgadmin.png') repeat-x scroll 0 0 #FFFFFF;margin: 0px">
	
		<div class="contenedor_admin">
			<div class="head_admin">
				<!-- {header} -->
			</div>
			<div id="botonera" style="clear: both;float:left; width: 20%;padding-top:12px;padding-left:10px;">
				<!-- {menu} -->
			</div>	
			<div id="detalle_producto" class="" style="margin-left: 15px;float: left; width:77%;padding-top:12px;">
			
				<!-- {body} -->
			</div>
		</div>
	</body>
	
</html>