<script language="javascript">
$(document).ready(registerAjaxForm<!-- {name} -->);

function registerAjaxForm<!-- {name} -->(){
	try{
		$("#<!-- {id} -->").submit(function () {
				alert("ddd");
				ajaxForm<!-- {name} -->(this);
				return false;
				});   

	}catch(e){alert(e)}
	 return false;
}




function ajaxForm<!-- {name} -->(form){
    $("#contentAjax<!-- {name} -->").ajaxStart(
        function inicioEnvio(){ $("#contentAjax<!-- {name} -->").html("<!-- {loading} -->") });
   
    $.ajax({
          url: form.action,
			 data:  $("#<!-- {id} -->").serialize(), 
          cache: false,
          scriptCharset: "utf-8",
          dataType: "text/html",
          contentType: "application/x-www-form-urlencoded",
          error: function(objeto, quepaso, otroobj){
                //alert("Estas viendo esto por que fallé");
                alert("Pasó lo siguiente: "+quepaso);
                },
          success: function(html){ $("contentAjax<!-- {name} -->").html(html);}
    });
}
</script>
<div id="contentAjax<!-- {name} -->" width="100px" height="50px" style="left: 0px; top: 0px; position: absolute" ></div>
<form action="<!-- {action} -->" name="<!-- {name} -->" id="<!-- {id} -->" method="<!-- {method} -->">
<input type="submit" >
<!-- {CONTENT} -->
</form>
